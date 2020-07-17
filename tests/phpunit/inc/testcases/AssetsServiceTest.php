<?php

use \Includes\Config;
use \Brain\Monkey\Actions;
use \Brain\Monkey\Functions;
use \Includes\Services\AssetsService;

class AssetsServiceTest extends \CERVTestCase {

    public function setUp(): void {
        parent::setUp();
        Config::init();
    }

    public function test_initialize_register_assets(){
        Actions\expectAdded('init')->once();

        ( new AssetsService() )->initialize();

        self::assertTrue( has_action('init', '\Includes\Services\AssetsService->registerAssets()') );
    }    

    public function test_enqueueScripts_actually_enqueue_scripts(){
        $assetsService = \Mockery::mock( AssetsService::class )->makePartial();

        $testScripts = ['script-one', 'script-two'];

        Functions\expect('wp_enqueue_script')
            ->times(1)
            ->with('script-one');

        Functions\expect('wp_enqueue_script')
            ->times(1)
            ->with('script-two');

        $assetsService->enqueueScripts($testScripts);
    }

    public function test_enqueueStyles_actually_enqueue_styles(){
        $assetsService = \Mockery::mock( AssetsService::class )->makePartial();

        $testStyles = ['style-one', 'style-two'];

        Functions\expect('wp_enqueue_style')
            ->times(1)
            ->with('style-one');

        Functions\expect('wp_enqueue_style')
            ->times(1)
            ->with('style-two');

        $assetsService->enqueueStyles($testStyles);
    }
}
