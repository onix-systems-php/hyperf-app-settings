<?php

declare(strict_types=1);
/**
 * This file is part of the extension library for Hyperf.
 *
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

namespace OnixSystemsPHP\HyperfAppSettings\Repository;

use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Context\ApplicationContext;
use Hyperf\Contract\ConfigInterface;
use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfCore\Constants\Time;
use OnixSystemsPHP\HyperfCore\Model\Builder;
use OnixSystemsPHP\HyperfCore\Repository\AbstractRepository;

/**
 * @method AppSetting create(array $data)
 * @method AppSetting update(AppSetting $model, array $data)
 * @method AppSetting save(AppSetting $model)
 * @method AppSettingsRepository|Builder finder(string $type, ...$parameters)
 * @method null|AppSetting fetchOne(bool $lock, bool $force)
 */
class AppSettingsRepository extends AbstractRepository
{
    protected string $modelClass = AppSetting::class;

    #[Cacheable(prefix: 'app:setting_list', ttl: Time::YEAR)]
    public function getSettingsList(): array
    {
        /** @var ConfigInterface $config */
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $settingsList = $config->get('app_settings.fields');
        $settings = [];
        /** @var AppSetting $setting */
        foreach ($this->query()->get()->all() as $setting) {
            $settings[$setting->name] = $setting;
        }
        foreach ($settingsList as $name => $data) {
            if (! isset($settings[$name])) {
                $settings[$name] = $this->create($data);
            }
        }
        return $settings;
    }

    public function getByName(string $name, bool $lock = false, bool $force = false): ?AppSetting
    {
        return $this->finder('name', $name)->fetchOne($lock, $force);
    }

    public function scopeName(Builder $query, string $name): void
    {
        $query->where('name', '=', $name);
    }
}
