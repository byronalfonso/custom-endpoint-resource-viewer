<?php

use Includes\Config;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use Includes\Services\AssetsService;

class AssetsServiceTest extends \CERVTestCase
{

    public function setUp(): void
    {

        parent::setUp();
        Config::init();
    }

    public function test_initialize_register_assets()
    {

        Actions\expectAdded('init')->once();

        ( new AssetsService() )->initialize();

        self::assertTrue(has_action('init', '\Includes\Services\AssetsService->registerAssets()'));
    }

    public function test_enqueueScripts_actually_enqueue_scripts()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $testScripts = ['cerv-resource-list'];

        Functions\expect('wp_enqueue_script')
            ->times(1)
            ->with('cerv-resource-list');

        $assetsService->enqueueScripts($testScripts);
    }

    public function test_enqueueStyles_actually_enqueue_styles()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $testStyles = ['cerv-resource-style', 'cerv-modal-style'];

        Functions\expect('wp_enqueue_style')
            ->times(1)
            ->with('cerv-resource-style');

        Functions\expect('wp_enqueue_style')
            ->times(1)
            ->with('cerv-modal-style');

        $assetsService->enqueueStyles($testStyles);
    }

    public function test_enqueueScripts_throw_error_for_empty_scripts()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error: Empty scripts passed. Expected array of valid string-formatted scripts");

        $assetsService->enqueueScripts([]);
    }

    public function test_enqueueStyles_throw_error_for_empty_styles()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error: Empty styles passed. Expected array of valid string-formatted styles");

        $assetsService->enqueueStyles([]);
    }

    public function test_enqueueScripts_throw_error_when_not_given_an_array()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();
        $this->expectException(\TypeError::class);
        $assetsService->enqueueScripts('not_an_array');
    }

    public function test_enqueueStyles_throw_error_when_not_given_an_array()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();
        $this->expectException(\TypeError::class);
        $assetsService->enqueueStyles('not_an_array');
    }
}
