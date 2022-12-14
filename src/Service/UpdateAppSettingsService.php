<?php
declare(strict_types=1);

namespace OnixSystemsPHP\HyperfAppSettings\Service;

use OnixSystemsPHP\HyperfAppSettings\Constants\AppSettings;
use OnixSystemsPHP\HyperfAppSettings\DTO\UpdateAppSettingDTO;
use OnixSystemsPHP\HyperfActionsLog\Event\Action;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfAppSettings\Repository\AppSettingsRepository;
use OnixSystemsPHP\HyperfCore\Service\Service;
use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

#[Service]
class UpdateAppSettingsService
{
    public const ACTION = 'updated_app_setting';

    public function __construct(
        private ValidatorFactoryInterface $vf,
        private AppSettingsRepository $rAppSettings,
        private AppSettingsService $appSettingsService,
        private EventDispatcherInterface $eventDispatcher,
    ) {
    }

    #[Transactional(attempts: 1)]
    public function run(UpdateAppSettingDTO $updateAppSettingDTO): ?AppSetting
    {
        $params = $this->validate($updateAppSettingDTO);
        $setting = $this->rAppSettings->getByName($params['name'], true);
        if (!empty($setting)) {
            $this->rAppSettings->update($setting, $params);
        } else {
            $setting = $this->rAppSettings->create($params);
        }
        $this->rAppSettings->save($setting);
        $this->appSettingsService->reload();
        $this->eventDispatcher->dispatch(new Action(self::ACTION, $setting, [
            'name' => $setting->name,
            'value' => $setting->value,
        ]));
        return $setting;
    }

    private function validate(UpdateAppSettingDTO $userData): array
    {
        if (!isset(AppSettings::SETTINGS_DATA[$userData->name])) {
            throw new BusinessException(422, __('exceptions.update_app_settings.wrong_type'));
        }
        $type = AppSettings::SETTINGS_DATA[$userData->name]['type'];
        $category = AppSettings::SETTINGS_DATA[$userData->name]['category'];
        $result = $this->vf
            ->make($userData->toArray(), array_merge([
                'name' => 'in:' . implode(',', AppSettings::SETTINGS_LIST),
            ], AppSettings::TYPES_VALIDATION[$type]))
            ->validate();
        $result['type'] = $type;
        $result['category'] = $category;
        return $result;
    }
}
