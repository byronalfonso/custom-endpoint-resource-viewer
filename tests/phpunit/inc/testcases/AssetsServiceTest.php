<?php

use \Includes\Config;
use \Brain\Monkey\Actions;
use \Brain\Monkey\Functions;
use \Includes\Services\AssetsService;

class AssetsServiceTest extends \CERVTestCase {

    public function test_initialize_register_assets(){
        Config::init();

        Actions\expectAdded('init')->once();

        ( new AssetsService() )->initialize();

        self::assertTrue( has_action('init', '\Includes\Services\AssetsService->registerAssets()') );
    }

}
