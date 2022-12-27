<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings;

use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpServer\Router\Router;
use Hyperf\Utils\ApplicationContext;

class ConfigProvider
{
    public function __invoke(): array
    {
        if (ApplicationContext::hasContainer()) {
            /** @var ConfigInterface $container */
            $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
            if (in_array('app-settings', $config->get('extensions', []))) {
                Router::addGroup('/v1/admin/app_settings', function () {
                    Router::get('', [Controller\AppSettingsController::class, 'index']);
                    Router::post('', [Controller\AppSettingsController::class, 'update']);
                });
            }
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
