<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Resource;

use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="ResourceAppSetting",
 *     type="object",
 *     @OA\Property(property="type", type="string", example="integer"),
 *     @OA\Property(property="name", type="string", example="SETTING_EXAMPLE_STRING"),
 *     @OA\Property(property="value", type="object", example="<TYPE_RELATED_VALUE>"),
 * )
 * @method __construct(AppSetting $resource)
 * @property AppSetting $resource
 */
class ResourceAppSetting extends AbstractResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(): array
    {
        return [
            'type' => $this->resource->type,
            'name' => $this->resource->name,
            'value' => $this->resource->value,
        ];
    }
}
