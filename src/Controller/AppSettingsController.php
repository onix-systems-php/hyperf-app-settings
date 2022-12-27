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
use OpenApi\Annotations as OA;

class AppSettingsController extends AbstractController
{
    /**
     * @OA\Get(
     *     path="/v1/admin/app_settings",
     *     summary="Get list of user's settings",
     *     operationId="appSettingsListing",
     *     tags={"app_settings"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(
     *         name="categories[]",
     *         in="query",
     *         explode=true,
     *         example="user",
     *         @OA\Schema(type="array", @OA\Items(type="string"))
     *     ),
     *     @OA\Response(response=200, description="", @OA\JsonContent(
     *         @OA\Property(property="status", type="string"),
     *         @OA\Property(property="data", ref="#/components/schemas/ResourceAppSettings"),
     *     )),
     *     @OA\Response(response=401, ref="#/components/responses/401"),
     *     @OA\Response(response=500, ref="#/components/responses/500"),
     * )
     */
    public function index(AppSettingsService $appSettingsService, RequestGetAppSettings $request): ResourceAppSettings
    {
        return ResourceAppSettings::make($appSettingsService->list($request->query('categories')));
    }

    /**
     * @OA\Post(
     *     path="/v1/admin/app_settings",
     *     summary="Update user's settings",
     *     operationId="updateAppSettings",
     *     tags={"app_settings"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Parameter(ref="#/components/parameters/Locale"),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/RequestUpdateAppSettings")),
     *     @OA\Response(response=200, description="", @OA\JsonContent(
     *         @OA\Property(property="status", type="string"),
     *         @OA\Property(property="data", ref="#/components/schemas/ResourceAppSetting"),
     *     )),
     *     @OA\Response(response=401, ref="#/components/responses/401"),
     *     @OA\Response(response=500, ref="#/components/responses/500"),
     * )
     */
    public function update(
        RequestUpdateAppSettings $requestUpdateSettingsUser,
        UpdateAppSettingsService $updateAppSettingsService,
    ): ResourceAppSetting {
        $settingsUpdated = $updateAppSettingsService->run(UpdateAppSettingDTO::make($requestUpdateSettingsUser));
        return ResourceAppSetting::make($settingsUpdated);
    }
}
