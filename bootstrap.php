<?php

declare(strict_types=1);

// Enable autoloading
if (file_exists(dirname(__FILE__) . '/vendor/autoload.php')) {
    require_once dirname(__FILE__) . '/vendor/autoload.php';
}

if( !function_exists('pd') ){
    // print and die;
    function pd($item){
        print_r($item);
        die;
    }
}
