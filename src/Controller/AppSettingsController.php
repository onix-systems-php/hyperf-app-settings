<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Controller;

use OnixSystemsPHP\HyperfAppSettings\DTO\UpdateAppSettingDTO;
use OnixSystemsPHP\HyperfAppSettings\Request\RequestGetAppSettings;
use OnixSystemsPHP\HyperfAppSettings\Request\RequestUpdateAppSettings;
use OnixSystemsPHP\HyperfAppSettings\Resource\ResourceAppSetting;
use OnixSystemsPHP\HyperfAppSettings\Resource\ResourceAppSettings;
use OnixSystemsPHP\HyperfAppSettings\Service\AppSettingsService;
use OnixSystemsPHP\HyperfAppSettings\Service\UpdateAppSettingsService;
use OnixSystemsPHP\HyperfCore\Controller\AbstractController;
use OpenApi\Attributes as OA;

class AppSettingsController extends AbstractController
{

    #[OA\Get(
        path: '/v1/admin/app_settings',
        operationId: 'appSettingsListing',
        summary: 'Get list of users settings',
        security: [['bearerAuth' => []]],
        tags: ['app_settings'],
        parameters: [new OA\Parameter(
            name: 'categories[]',
            in: 'query',
            explode: true,
            example: 'user',
            schema: new OA\Schema(type: 'array', items: new OA\Items(type: 'string'))
        )],
        responses: [
            new OA\Response(response: 200, description: '', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/ResourceAppSettings'),
            ])),
            new OA\Response(response: 401, ref: '#/components/responses/401'),
            new OA\Response(response: 500, ref: '#/components/responses/500'),
        ],
    )]
    public function index(AppSettingsService $appSettingsService, RequestGetAppSettings $request): ResourceAppSettings
    {
        return ResourceAppSettings::make($appSettingsService->list($request->query('categories')));
    }


    #[OA\Post(
        path: '/v1/admin/app_settings',
        operationId: 'updateAppSettings',
        summary: 'Update users settings',
        security: [['bearerAuth' => []]],
        requestBody: new OA\RequestBody(required: true, content: new OA\JsonContent(ref: '#/components/schemas/RequestUpdateAppSettings')),
        tags: ['app_settings'],
        parameters: [new OA\Parameter(ref: '#/components/parameters/Locale')],
        responses: [
            new OA\Response(response: 200, description: '', content: new OA\JsonContent(properties: [
                new OA\Property(property: 'status', type: 'string'),
                new OA\Property(property: 'data', ref: '#/components/schemas/ResourceAppSetting'),
            ])),
            new OA\Response(response: 401, ref: '#/components/responses/401'),
            new OA\Response(response: 500, ref: '#/components/responses/500'),
        ]
    )]
    public function update(
        RequestUpdateAppSettings $requestUpdateSettingsUser,
        UpdateAppSettingsService $updateAppSettingsService,
    ): ResourceAppSetting {
        $settingsUpdated = $updateAppSettingsService->run(UpdateAppSettingDTO::make($requestUpdateSettingsUser));
        return ResourceAppSetting::make($settingsUpdated);
    }
}
