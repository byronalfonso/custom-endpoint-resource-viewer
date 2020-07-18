<?php

declare(strict_types=1);

/*
Plugin Name: Custom Endpoint Resource Viewer
Plugin URI: https://github.com/byronalfonso
Author: Byron Alfonso
Author URI: https://github.com/byronalfonso
Description: CERV generates a custom endpoint that allows a user to view a resource from an external API on that endpoint.
Text Domain: custom-endpoint-resource-viewer
Version: 1.0.0
*/

defined('ABSPATH') || exit;

require_once dirname(__FILE__) . '/bootstrap.php';

// Setup activation hook
register_activation_hook( __FILE__, function(){
  flush_rewrite_rules();
});

// Setup deactivation hook
register_deactivation_hook( __FILE__, function(){
  flush_rewrite_rules();
});

/**
 * Initialize and run the plugin
 */
if (class_exists('Includes\\CERV')) {
    Includes\CERV::run();
}
