<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfAppSettings\Resource;

use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfCore\Resource\AbstractResource;
use OpenApi\Attributes as OA;

/**
 * @method __construct(AppSetting $resource)
 * @property AppSetting $resource
 */
#[OA\Schema(
    schema: 'ResourceAppSetting',
    properties: [
        new OA\Property(property: 'type', type: 'string', example: 'integer'),
        new OA\Property(property: 'name', type: 'string', example: 'SETTING_EXAMPLE_STRING'),
        new OA\Property(property: 'value', type: 'object', example: '<TYPE_RELATED_VALUE>'),
    ],
    type: 'object'
)]
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
