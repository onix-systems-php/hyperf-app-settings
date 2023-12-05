<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
use Hyperf\HttpServer\Router\Router;
use OnixSystemsPHP\HyperfAppSettings\Controller\AppSettingsController;

Router::addGroup('/v1/admin/app_settings', function () {
    Router::get('', [AppSettingsController::class, 'index']);
    Router::post('', [AppSettingsController::class, 'update']);
});
