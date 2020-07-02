<?php
namespace Includes\Services;

class CustomEndpointService
{
	public function initialize()
	{
        add_action('init', array($this, 'custom_enpoint_rewrite_rule') );
        add_action( 'init', array($this, 'custom_rewrite_tag') );        
        add_filter( 'template_include', array($this, 'override_custom_enpoint_template') );
    }

    function custom_enpoint_rewrite_rule() {	
        add_rewrite_rule('^cerv$', 'index.php?cerv=1', 'top');
        flush_rewrite_rules();  
    }

    function custom_rewrite_tag( $vars ) {
        add_rewrite_tag( '%cerv%', '([^&]+)');
    }
    
    function override_custom_enpoint_template( $original_template ) {
        $customEndpoint = get_query_var( 'cerv' );

        if ( $customEndpoint ) {
            $template = plugin_dir_path( __FILE__ ) . 'templates/custom.php';
            return $template;
        }

        return $original_template;
    }
}
