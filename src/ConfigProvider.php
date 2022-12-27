<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings;

use Hyperf\HttpServer\Router\Router;
use Hyperf\Utils\ApplicationContext;

class ConfigProvider
{
    public function __invoke(): array
    {
        if (ApplicationContext::hasContainer()) {
            Router::addGroup('/v1/admin/action_logs', function () {
                Router::get('', [Controller\ActionLogsController::class, 'index']);
            });
        }

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
