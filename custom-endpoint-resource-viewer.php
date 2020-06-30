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

// Enable autoloading
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}


use Includes\TestClass;
$testClass = new TestClass();
