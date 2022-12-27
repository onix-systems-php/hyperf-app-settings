<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Resource;

use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ResourceAppSettings",
 *     type="object",
 *     @OA\Property(property="<APP_SETTING_NAME>", ref="#/components/schemas/ResourceAppSetting")
 * )
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
