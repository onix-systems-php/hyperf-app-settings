<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Model;

use Carbon\Carbon;
use OnixSystemsPHP\HyperfCore\Model\AbstractModel;

/**
 * @property int $id
 * @property string $type
 * @property string $category
 * @property string $name
 * @property string $value
 * @property ?Carbon $created_at
 * @property ?Carbon $updated_at
 */
class AppSetting extends AbstractModel
{
    protected $table = 'app_settings';

    protected $guarded = [];

    protected $hidden = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'id' => 'integer',
        'type' => 'string',
        'category' => 'string',
        'name' => 'string',
        'value' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
