<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Resource;

use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: 'ResourceAppSettings',
    properties: [
        new OA\Property(property: '<APP_SETTING_NAME>', ref: '#/components/schemas/ResourceAppSetting')
    ],
    type: 'object'
)]
/**
 * @method __construct(AppSetting[] $resource)
 * @property AppSetting[] $resource
 */
class ResourceAppSettings extends AbstractResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return ResourceAppSetting::collection($this->resource)->toArray();
    }
}
