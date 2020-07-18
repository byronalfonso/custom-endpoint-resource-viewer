<?php

// fake the ABSPATH
if (! defined('ABSPATH')) {
    define('ABSPATH', sys_get_temp_dir());
}

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/inc/CERVTestCase.php';
