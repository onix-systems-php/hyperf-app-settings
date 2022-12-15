# Hyperf-app-settings component

Includes the following classes:
 
- DTO:
  - UpdateAppSettingDTO.
- Model:
  - AppSetting;
- Repository:
  - AppSettingsRepository.
- Service:
  - AppSettingsService.
  - UpdateAppSettingsService.

Install:
```shell script
composer require onix-systems-php/hyperf-app-settings
```

Publish config and database migrations:
```shell script
php bin/hyperf.php vendor:publish onix-systems-php/hyperf-app-settings
```

Fill `app_settings` config with fields you want to store in database and validation rules for them, following existing examples.  
