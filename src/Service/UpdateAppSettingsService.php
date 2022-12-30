<?php

declare(strict_types=1);
namespace OnixSystemsPHP\HyperfAppSettings\Service;

use Hyperf\Contract\ConfigInterface;
use Hyperf\DbConnection\Annotation\Transactional;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use OnixSystemsPHP\HyperfActionsLog\Event\Action;
use OnixSystemsPHP\HyperfAppSettings\DTO\UpdateAppSettingDTO;
use OnixSystemsPHP\HyperfAppSettings\Model\AppSetting;
use OnixSystemsPHP\HyperfAppSettings\Repository\AppSettingsRepository;
use OnixSystemsPHP\HyperfCore\Contract\CorePolicyGuard;
use OnixSystemsPHP\HyperfCore\Exception\BusinessException;
use OnixSystemsPHP\HyperfCore\Service\Service;
use Psr\EventDispatcher\EventDispatcherInterface;

#[Service]
class UpdateAppSettingsService
{
    public const ACTION = 'updated_app_setting';

    public function __construct(
        private ValidatorFactoryInterface $vf,
        private ConfigInterface $config,
        private AppSettingsRepository $rAppSettings,
        private AppSettingsService $appSettingsService,
        private EventDispatcherInterface $eventDispatcher,
        private ?CorePolicyGuard $policyGuard = null,
    ) {
    }

    #[Transactional(attempts: 1)]
    public function run(UpdateAppSettingDTO $updateAppSettingDTO): ?AppSetting
    {
        $params = $this->validate($updateAppSettingDTO);
        $setting = $this->rAppSettings->getByName($params['name'], true);
        if (! empty($setting)) {
            $this->policyGuard?->check('update', $setting, $params);
            $this->rAppSettings->update($setting, $params);
        } else {
            $setting = $this->rAppSettings->create($params);
            $this->policyGuard?->check('create', $setting);
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
        $settingsList = $this->config->get('app_settings.fields');
        $settingsTypes = $this->config->get('app_settings.types');
        if (! array_key_exists($userData->name, $settingsList)) {
            throw new BusinessException(422, __('exceptions.app_settings.update_wrong_type'));
        }
        $type = $settingsList[$userData->name]['type'];
        $category = $settingsList[$userData->name]['category'];
        $result = $this->vf
            ->make($userData->toArray(), array_merge([
                'name' => 'in:' . implode(',', array_keys($settingsList)),
            ], $settingsTypes[$type]))
            ->validate();
        $result['type'] = $type;
        $result['category'] = $category;
        return $result;
    }
}
