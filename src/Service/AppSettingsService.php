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
use OnixSystemsPHP\HyperfAppSettings\Repository\AppSettingsRepository;
use OnixSystemsPHP\HyperfCore\Contract\CorePolicyGuard;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfCore\Service\Service;

use function Hyperf\Translation\__;

#[Service]
class AppSettingsService
{
    private array $appSettings;

    public function __construct(
        private ConfigInterface $config,
        private AppSettingsRepository $rAppSettings,
        private ?CorePolicyGuard $policyGuard,
    ) {
        $this->reload();
    }

    #[CacheEvict(prefix: 'app:setting_list')]
    public function reload(): void
    {
        $this->appSettings = $this->rAppSettings->getSettingsList();
    }

    public function get(string $setting)
    {
        $settingsList = $this->config->get('app_settings.fields');
        if (! array_key_exists($setting, $settingsList)) {
            throw new BusinessException(404, __('exceptions.app_settings.get_wrong_type'));
        }
        if (! isset($this->appSettings[$setting])) {
            $this->reload();
        }
        $this->policyGuard?->check('view', $this->appSettings[$setting]);
        return $this->appSettings[$setting]->value;
    }

    public function list(?array $categoryFilter = null): array
    {
        $this->policyGuard?->check('list', $this->rAppSettings);
        return array_filter(
            $this->appSettings,
            fn ($setting) => is_null($categoryFilter) || in_array($setting->category, $categoryFilter)
        );
    }
}
