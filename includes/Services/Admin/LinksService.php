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
        add_filter("plugin_action_links_$pluginName", [ $this, 'registerLinks' ]);
    }

    /**
     * Registers all my custom /wp-admins/plugins.php page links to WordPress
     * @return void
     */
    public function registerLinks(array $originalLinks): array
    {
        
        foreach ($this->links as $link) {
            array_push($originalLinks, $link);
        }
        
        return $originalLinks;
    }

    /**
     * This is where all the links under the plugin name (on /wp-admins/plugins.php page) are set
     * @return void
     */
    private function setLinks()
    {

        $this->links = [
            '<a href="admin.php?page=cerv_settings">Settings</a>',
            '<a href="/' . Config::get('defaultEndpoint') . '">Go to the resource page</a>',
        ];
    }
}
