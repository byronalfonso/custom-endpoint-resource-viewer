<?php

declare(strict_types=1);

namespace Includes\Pages;

use Includes\Config;
use Includes\Interfaces\PageInterface;
use Includes\Managers\TemplateManager;

class Settings implements PageInterface
{
    private $options = [];

    public function getOptions(){
        return $this->options;
    }

    public function initPage(){
        $this->setOptions();
    }

    private function setOptions(){
        $this->options = [
            "page_title" => "Settings",
            "menu_title" => "CERV Settings",
            "capability" => "manage_options",
            "menu_slug" => "cerv_settings",
            "callback" => [$this, 'settingsPage'],
            "icon_url" => "dashicons-admin-generic",
            "position" => 200
        ];
    }

    public function settingsPage(){
        return require_once TemplateManager::pluginTemplate('settings.php');
    }
}
