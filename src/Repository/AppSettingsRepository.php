<?php
declare(strict_types=1);

namespace OnixSystemsPHP\HyperfAppSettings\Repository;

use OnixSystemsPHP\HyperfAppSettings\Constants\AppSettings;
use OnixSystemsPHP\HyperfAppSettings\Constants\Time;
use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use Hyperf\Cache\Annotation\Cacheable;
use OnixSystemsPHP\HyperfCore\Repository\AbstractRepository;
use Hyperf\Database\Model\Builder;

/**
 * @method AppSetting create(array $data)
 * @method AppSetting update(AppSetting $model, array $data)
 * @method AppSetting save(AppSetting $model)
 */
class AppSettingsRepository extends AbstractRepository
{
    protected string $modelClass = AppSetting::class;

    #[Cacheable(prefix: 'app:setting_list', ttl: Time::YEAR)]
    public function getSettingsList(): array
    {
        $settings = [];
        foreach (AppSetting::all()->all() as $setting) {
            $settings[$setting->name] = $setting;
        }
        foreach (AppSettings::SETTINGS_LIST as $setting) {
            if (!isset($settings[$setting])) {
                $settings[$setting] = new AppSetting(AppSettings::SETTINGS_DATA[$setting]);
            }
        }
        return $settings;
    }

    //-----$paginationDTO

    public function getByName(string $name, bool $lock = false, bool $force = false): ?AppSetting
    {
        return $this->fetchOne($this->queryByName($name), $lock, $force);
    }
    public function queryByName(string $name): Builder
    {
        return $this->query()->where('name', $name);
    }

    //-----

    protected function fetchOne(Builder $builder, bool $lock, bool $force): ?AppSetting
    {
        /** @var ?AppSetting $result */
        $result = parent::fetchOne($builder, $lock, $force);
        return $result;
    }
}
