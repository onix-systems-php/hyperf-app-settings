<?php
declare(strict_types=1);

namespace OnixSystemsPHP\HyperfAppSettings\Service;

use OnixSystemsPHP\HyperfAppSettings\Constants\AppSettings;
use OnixSystemsPHP\HyperfAppSettings\Constants\Time;
use OnixSystemsPHP\HyperfAppSettings\Exception\BusinessException;
use OnixSystemsPHP\HyperfAppSettings\Repository\AppSettingsRepository;
use Hyperf\Cache\Annotation\CacheEvict;
use OnixSystemsPHP\HyperfCore\Service\Service;

#[Service]
class AppSettingsService
{
    private array $appSettings;

    public function __construct(
        private AppSettingsRepository $rAppSettings,
    ) {
        $this->reload();
    }

    #[CacheEvict(prefix: 'app:setting_list', ttl: Time::YEAR)]
    public function reload(): void
    {
        $this->appSettings = $this->rAppSettings->getSettingsList();
    }

    public function get(string $setting)
    {
        if (in_array($setting, AppSettings::SETTINGS_LIST)) {
            if (!isset($this->appSettings[$setting])) {
                $this->reload();
            }
            return $this->appSettings[$setting]->value;
        } else {
            throw new BusinessException(404, __('get_app_settings.wrong_type'));
        }
    }

    public function list(?array $categoryFilter = null): array
    {
        return array_filter($this->appSettings, fn($setting) =>
            is_null($categoryFilter) || in_array($setting->category, $categoryFilter));
    }
}
