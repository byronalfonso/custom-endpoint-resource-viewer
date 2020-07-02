<?php
/**
 * @package  CERV
 */
/*
Plugin Name: Custom Endpoint Resource Viewer
Plugin URI: https://github.com/byronalfonso
Author: Byron Alfonso
Author URI: https://github.com/byronalfonso
Description: CERV generates a custom endpoint that allows a user to view a resource from an external API on that endpoint.
Text Domain: custom-endpoint-resource-viewer
Version: 1.0.0
*/

defined( 'ABSPATH' ) || exit;

// echo();
// die;


// Enable autoloading
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


function cerv_activate_plugin() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cerv_activate_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function cerv_deactivate_plugin() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cerv_deactivate_plugin' );

function custom_enpoint_rewrite_rule() {	
	add_rewrite_rule('^cerv$', 'index.php?cerv=1', 'top');
	flush_rewrite_rules();  
}
add_action('init', 'custom_enpoint_rewrite_rule');

function custom_rewrite_tag( $vars ) {
	add_rewrite_tag( '%cerv%', '([^&]+)');
}
add_action( 'init', 'custom_rewrite_tag');

function override_custom_enpoint_template( $original_template ) {
	$customEndpoint = get_query_var( 'cerv' );
	
	if ( $customEndpoint ) {
		$template = plugin_dir_path( __FILE__ ) . 'templates/custom.php';
		return $template;
	}
	
	return $original_template;
}
add_filter( 'template_include', 'override_custom_enpoint_template' );