<?php
namespace Includes\Services;

use Includes\Config;

class CustomEndpointService
{
    private $defaultEndpoint;

	public function initialize()
	{
        $this->defaultEndpoint = Config::get('defaultEndpoint');
        add_action('init', array($this, 'custom_enpoint_rewrite_rule') );
        add_action( 'init', array($this, 'custom_rewrite_tag') );        
        add_filter( 'template_include', array($this, 'override_custom_enpoint_template') );
    }

    function custom_rewrite_tag( $vars ) {
        add_rewrite_tag( "%cerv_endpoint%", '([^&]+)');
    }

    function custom_enpoint_rewrite_rule() {
        // note: possibly move the default endpoint into a separate function once we add a settings page for it
        add_rewrite_rule("^{$this->defaultEndpoint}$", 'index.php?cerv_endpoint=1', 'top');
        flush_rewrite_rules();
    }
    
    function override_custom_enpoint_template( $original_template ) {
        $queryVar = get_query_var( 'cerv_endpoint' );
        
        if ( $queryVar ) {
            $template = Config::get('templatePath') . 'custom.php';
            return $template;
        }

        return $original_template;
    }
}
