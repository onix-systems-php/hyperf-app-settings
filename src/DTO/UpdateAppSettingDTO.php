<?php
declare(strict_types=1);

namespace OnixSystemsPHP\HyperfAppSettings\DTO;

use OnixSystemsPHP\HyperfCore\DTO\AbstractDTO;

class UpdateAppSettingDTO extends AbstractDTO
{
    public string $type;

    public string $category;

    public string $name;

    public $value;
}
