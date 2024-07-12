<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfAppSettings\Service;

use Hyperf\Cache\Annotation\CacheEvict;
use Hyperf\Contract\ConfigInterface;
use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfAppSettings\Repository\AppSettingsRepository;
use OnixSystemsPHP\HyperfCore\Contract\CorePolicyGuard;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfCore\Service\Service;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function Hyperf\Translation\__;

#[Service]
class AppSettingsService
{
    public function __construct(
        private readonly ConfigInterface $config,
        private readonly AppSettingsRepository $rAppSettings,
        private readonly ?CorePolicyGuard $policyGuard,
    ) {}

    #[CacheEvict(prefix: 'app:setting_list')]
    public function reload(): void {}

    /**
     * @return array<string, AppSetting>
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function load(): array
    {
        return $this->rAppSettings->getSettingsList();
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $setting): string
    {
        $appSettings = $this->load();

        $settingsList = $this->config->get('app_settings.fields');
        if (! array_key_exists($setting, $settingsList)) {
            throw new BusinessException(404, __('exceptions.app_settings.get_wrong_type'));
        }
        if (! isset($appSettings[$setting])) {
            $this->reload();
        }
        $this->policyGuard?->check('view', $appSettings[$setting]);
        return $appSettings[$setting]->value;
    }

    /**
     * @param null|string[] $categoryFilter
     * @return array<string, AppSetting>
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function list(?array $categoryFilter = null): array
    {
        $this->policyGuard?->check('list', $this->rAppSettings);
        return array_filter(
            $this->load(),
            fn (AppSetting $setting) => is_null($categoryFilter) || in_array($setting->category, $categoryFilter)
        );
    }
}
