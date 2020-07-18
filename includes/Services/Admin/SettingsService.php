<?php

declare(strict_types=1);

namespace Includes\Services\Admin;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

class SettingsService implements PluginServiceInterface
{
    private static $addedSettings = [];
    private $settings = [];

    public function initialize()
    {
        $this->setSettings();
        if (!empty($this->settings)) {
            add_action('admin_init', [ $this, 'registerSettings' ]);
        }
    }

    public function registerSettings()
    {
        
        foreach ($this->settings as $class) {
            // Add the page only if it hasn't been added yet
            if (in_array($class, self::$addedSettings, true)) {
                continue;
            }

            // Throw an error if the page is not an instance of SettingInterface
            if (!is_subclass_of($class, 'Includes\Interfaces\SettingInterface')) {
                throw new \Exception("Invalid setting initialization. " . $class . " must be an instance of the SettingInterface.");
            }

            $setting = new $class();
            $setting->initSettings();
            $this->register($setting->options());
            $this->registerSections($setting->sections());
            $this->registerFields($setting->fields());
            array_push(self::$addedSettings, $class);
        }
    }

    private function setSettings()
    {

        $this->settings = [
            \Includes\Settings\SettingsPage::class,
        ];
    }

    private function register(array $settingOptions)
    {

        foreach ($settingOptions as $setting) {
            register_setting($setting["option_group"], $setting["option_name"], ( isset($setting["callback"]) ? $setting["callback"] : '' ));
        }
    }

    private function registerSections(array $sections)
    {

        foreach ($sections as $section) {
            add_settings_section($section["id"], $section["title"], ( isset($section["callback"]) ? $section["callback"] : '' ), $section["page"]);
        }
    }

    private function registerFields(array $settingFields)
    {

        foreach ($settingFields as $field) {
            add_settings_field(
                $field["id"],
                $field["title"],
                ( isset($field["callback"]) ? $field["callback"] : '' ),
                $field["page"],
                $field["section"],
                ( isset($field["args"]) ? $field["args"] : '' )
            );
        }
    }
}
