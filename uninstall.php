<?php

declare(strict_types=1);

if (!defined('WP_UNINSTALL_PLUGIN')) die;

$settingOptions = ['resource_select', 'cerv_custom_endpoint_field'];
 
// Clean up Settings
foreach ( $settingOptions as $option ) {
    delete_option( $option );
}