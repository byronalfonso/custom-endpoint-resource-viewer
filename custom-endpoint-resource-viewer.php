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

defined('ABSPATH') || exit;
/*
  - Add a bootstrap file
 - Add a config file or class
   - Setup the main plugin file
   - Setup/Prepare Services and Managers
*/

require_once dirname(__FILE__) . '/bootstrap.php';
/**
 * Initialize and run the plugin
 */
if (class_exists('Includes\\CERV')) {
    Includes\CERV::run();
}
