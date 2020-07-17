<?php

// fake the ABSPATH
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', sys_get_temp_dir() );
}

// Add our plugin's ABSPATH
if ( ! defined( 'CERV_ABSPATH' ) ) {
	define( 'CERV_ABSPATH', sys_get_temp_dir() . '/wp-content/plugins/custom-endpoint-resource-viewer/' );
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/inc/CERVTestCase.php';
