<?php
namespace Includes\Services;

use Includes\Config;
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
        add_filter( 'template_include', array($this, 'override_custom_enpoint_template') );
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
    
    public function override_custom_enpoint_template( $original_template ) {
        $queryVar = get_query_var( 'cerv_endpoint' );
        
        if ( $queryVar ) {
            $resourceService = new ResourceService();
            $resource = $resourceService->getResource('/users');
            return TemplateManager::getPluginTemplate('custom.php') ?: $original_template;
        }

        return $original_template;
    }
}
