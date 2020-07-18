<?php

declare(strict_types=1);

namespace Includes\Services\Admin;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

class LinksService implements PluginServiceInterface
{
    private $links = [];

    public function initialize()
    {
        $this->setLinks();
        $pluginName = Config::get('pluginName');
        add_filter( "plugin_action_links_$pluginName", array( $this, 'registerLinks' ) );
    }

    public function registerLinks($originalLinks){
        
        foreach ($this->links as $link) {
            array_push( $originalLinks, $link );
        }
		
		return $originalLinks;
    }

    private function setLinks(){
        $this->links = [
            '<a href="admin.php?page=cerv_settings">Settings</a>',
            '<a href="/' . Config::get('defaultEndpoint') . '">Go to the resource page</a>',
        ];
    }
}
