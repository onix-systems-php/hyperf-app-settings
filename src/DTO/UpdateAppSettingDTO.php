<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfAppSettings\DTO;

use OnixSystemsPHP\HyperfCore\DTO\AbstractDTO;

class UpdateAppSettingDTO extends AbstractDTO
{
    public string $type;

    public string $category;

    public string $name;

    public array $value;
}
