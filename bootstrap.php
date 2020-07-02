<?php
// Enable autoloading
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

// Setup activation hook
function cerv_activate_plugin() {
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'cerv_activate_plugin' );

// Setup deactivation hook
function cerv_deactivate_plugin() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'cerv_deactivate_plugin' );