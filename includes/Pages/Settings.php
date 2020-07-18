<?php

declare(strict_types=1);

namespace Includes\Pages;

use Includes\Config;
use Includes\Interfaces\PageInterface;
use Includes\Managers\TemplateManager;

class Settings implements PageInterface
{
    private $options = [];

    public function options(){
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
        /*
            Nonce action key will be used to block illegal 
            access to the settings.php and will be used to verify wp_nonce
        */ 
        $nonceActionKey = Config::get('settingsNonceKey');
        return require_once TemplateManager::pluginTemplate('settings.php');
    }
}
