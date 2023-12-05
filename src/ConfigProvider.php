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

namespace OnixSystemsPHP\HyperfAppSettings;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => [
            ],
            'commands' => [
            ],
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            'publish' => [
                [
                    'id' => 'migration_base',
                    'description' => 'The addition for migration from onix-systems-php/hyperf-app-settings.',
                    'source' => __DIR__ . '/../publish/migrations/2022_04_18_122005_create_app_settings_table.php',
                    'destination' => BASE_PATH . '/migrations/2022_04_18_122005_create_app_settings_table.php',
                ],
                [
                    'id' => 'migration_category',
                    'description' => 'The addition for migration from onix-systems-php/hyperf-app-settings.',
                    'source' => __DIR__ . '/../publish/migrations/2022_05_10_111104_add_category_field_to_app_settings_table.php',
                    'destination' => BASE_PATH . '/migrations/2022_05_10_111104_add_category_field_to_app_settings_table.php',
                ],
                [
                    'id' => 'config',
                    'description' => 'The config for onix-systems-php/hyperf-app-settings.',
                    'source' => __DIR__ . '/../publish/config/app_settings.php',
                    'destination' => BASE_PATH . '/config/autoload/app_settings.php',
                ],
            ],
        ];
    }
}
