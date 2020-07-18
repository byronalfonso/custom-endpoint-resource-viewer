<?php

declare(strict_types=1);

namespace Includes\Services\Admin;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

class SettingsService implements PluginServiceInterface
{
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
            $setting = new $class();
            $setting->initSettings();
            $this->register($setting->getOptions());
            $this->registerSections($setting->getSections());
            $this->registerFields($setting->getFields());
        }
    }

    private function setSettings()
    {

        $this->settings = [
            \Includes\Settings\SettingsPage::class,
        ];
    }

    private function register($settingOptions)
    {

        foreach ($settingOptions as $setting) {
            register_setting($setting["option_group"], $setting["option_name"], ( isset($setting["callback"]) ? $setting["callback"] : '' ));
        }
    }

    private function registerSections($sections)
    {

        foreach ($sections as $section) {
            add_settings_section($section["id"], $section["title"], ( isset($section["callback"]) ? $section["callback"] : '' ), $section["page"]);
        }
    }

    private function registerFields($settingFields)
    {

        foreach ($settingFields as $field) {
            add_settings_field($field["id"], $field["title"], ( isset($field["callback"]) ? $field["callback"] : '' ), $field["page"], $field["section"], ( isset($field["args"]) ? $field["args"] : '' ));
        }
    }
}
