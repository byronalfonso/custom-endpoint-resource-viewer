<?php
namespace Includes\Services;

use Includes\Config;
use Includes\Services\AssetsService;
use Includes\Managers\TemplateManager;
use Includes\Services\API\ResourceService;
use Includes\Interfaces\PluginServiceInterface;

class CustomEndpointService implements PluginServiceInterface
{
    private $defaultEndpoint;

	public function initialize()
	{
        $this->defaultEndpoint = Config::get('defaultEndpoint');
        add_action('init', array($this, 'custom_enpoint_rewrite_rule') );
        add_action( 'init', array($this, 'custom_rewrite_tag') );
        // add_filter( 'query_vars',  array($this, 'add_query_vars')); // alternative solution to add_rewrite_tag
        add_action('template_redirect', array($this, 'override_template') );
    }

    public function custom_rewrite_tag( $vars ) {
        add_rewrite_tag( "%cerv_endpoint%", '([^&]+)');
    }

    // alternative solution to add_rewrite_tag
    public function add_query_vars( $query_vars ){
        $query_vars[] = 'cerv_endpoint';
        return $query_vars;
    }

    public function custom_enpoint_rewrite_rule() {
        // note: possibly move the default endpoint into a separate function once we add a settings page for it
        add_rewrite_rule("^{$this->defaultEndpoint}$", 'index.php?cerv_endpoint=1', 'top');
        flush_rewrite_rules();
    }

    public function override_template()
    {
        $queryVar = get_query_var( 'cerv_endpoint' );
        
        if ( $queryVar ) {       
            $assets = AssetsService::getInstance();
            $assets->enqueueScripts(['cerv-resource-list']);
            $assets->enqueueStyles(['cerv-resource-style', 'cerv-modal-style']);

            $resourceService = new ResourceService();
            $users = $resourceService->getResource('/users');

            if($users['hasErrors']){
                $error = $users;
                require_once TemplateManager::getPluginTemplate('error.php');
            }else{
                $resource = array(
                    'title' => 'Users',
                    'data' => $users['data']
                );
                require_once TemplateManager::getPluginTemplate('custom.php');
            }
            
            die;
        }
    }
}
