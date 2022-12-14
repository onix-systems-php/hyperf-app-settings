<?php
declare(strict_types=1);

namespace OnixSystemsPHP\HyperfAppSettings\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

#[Constants]
class AppSettings extends AbstractConstants
{
    public const SETTING_EXAMPLE_INTEGER = 'example_integer';
    public const SETTING_EXAMPLE_STRING = 'example_string';
    public const SETTING_EXAMPLE_EMAILS = 'example_emails';

    public const SETTINGS_LIST = [
        self::SETTING_EXAMPLE_INTEGER,
        self::SETTING_EXAMPLE_EMAILS,
        self::SETTING_EXAMPLE_STRING,
    ];

    public const SETTINGS_DATA = [
        self::SETTING_EXAMPLE_INTEGER => [
            'type' => self::TYPE_INTEGER,
            'category' => self::CATEGORY_EXAMPLE_USER,
            'name' => self::SETTING_EXAMPLE_INTEGER,
            "value" => [
                "data" => 1024,
            ],
        ],
        self::SETTING_EXAMPLE_STRING => [
            'type' => self::TYPE_STRING,
            'category' => self::CATEGORY_EXAMPLE_USER,
            'name' => self::SETTING_EXAMPLE_STRING,
            "value" => [
                "data" => 'Enabled',
            ],
        ],
        self::SETTING_EXAMPLE_EMAILS => [
            'type' => self::TYPE_ARRAY_OF_EMAILS,
            'category' => self::CATEGORY_EXAMPLE_MANAGER,
            'name' => self::SETTING_EXAMPLE_EMAILS,
            "value" => [],
        ],
    ];

    //-----

    public const TYPE_INTEGER = 'integer';
    public const TYPE_STRING = 'string';
    public const TYPE_ARRAY_OF_EMAILS = 'array_of_emails';

    public const TYPES_LIST = [
        self::TYPE_INTEGER,
        self::TYPE_STRING,
        self::TYPE_ARRAY_OF_EMAILS,
    ];

    public const TYPES_VALIDATION = [
        self::TYPE_INTEGER => [
            'value.data' => 'required|numeric|max:1024',
        ],
        self::TYPE_STRING => [
            'value.data' => 'required|string|max:100',
        ],
        self::TYPE_ARRAY_OF_EMAILS => [
            'value.*' => 'email',
        ],
    ];

    //-----
    public const CATEGORY_EXAMPLE_MANAGER = 'example_manager';
    public const CATEGORY_EXAMPLE_USER = 'example_user';

    public const CATEGORIES_LIST = [
        self::CATEGORY_EXAMPLE_MANAGER,
        self::CATEGORY_EXAMPLE_USER,
    ];
}
