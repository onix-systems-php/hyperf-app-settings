<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

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
    protected ?string $table = 'app_settings';

    protected array $guarded = [];

    protected array $hidden = ['id', 'created_at', 'updated_at'];

    protected array $casts = [
        'id' => 'integer',
        'type' => 'string',
        'category' => 'string',
        'name' => 'string',
        'value' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
