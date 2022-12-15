<?php
declare(strict_types=1);

namespace OnixSystemsPHP\HyperfAppSettings\Repository;

use Hyperf\Cache\Annotation\Cacheable;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Database\Model\Builder;
use Hyperf\Utils\ApplicationContext;
use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfCore\Constants\Time;
use OnixSystemsPHP\HyperfCore\Repository\AbstractRepository;

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
        /** @var ConfigInterface $config */
        $config = ApplicationContext::getContainer()->get(ConfigInterface::class);
        $settingsList = $config->get('app_settings.fields');
        $settings = [];
        foreach (AppSetting::all()->all() as $setting) {
            $settings[$setting->name] = $setting;
        }
        foreach ($settingsList as $name => $data) {
            if (!isset($settings[$name])) {
                $settings[$name] = (new AppSetting())->fill($data);
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
