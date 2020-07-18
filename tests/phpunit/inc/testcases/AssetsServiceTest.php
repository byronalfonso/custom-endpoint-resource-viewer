<?php

declare(strict_types=1);

namespace Tests\Inc\Testcases;

use Includes\Config;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use Tests\Inc\CERVTestCase;
use Includes\Services\AssetsService;

class AssetsServiceTest extends CERVTestCase
{

    public function setUp(): void
    {

        parent::setUp();
        Config::init();
    }

    public function testInitializeRegisterAssets()
    {

        Actions\expectAdded('init')->once();

        ( new AssetsService() )->initialize();

        self::assertTrue(has_action('init', '\Includes\Services\AssetsService->registerAssets()'));
    }

    public function testEnqueueScriptsActuallyEnqueueScripts()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $testScripts = ['cerv-resource-list'];

        Functions\expect('wp_enqueue_script')
            ->times(1)
            ->with('cerv-resource-list');

        $assetsService->enqueueScripts($testScripts);
    }

    public function testEnqueueStylesActuallyEnqueueStyles()
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

    public function testEnqueueScriptsThrowErrorForEmptyScripts()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error: Empty scripts passed. Expected array of valid string-formatted scripts");

        $assetsService->enqueueScripts([]);
    }

    public function testEnqueueStylesThrowErrorForEmptyStyles()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Error: Empty styles passed. Expected array of valid string-formatted styles");

        $assetsService->enqueueStyles([]);
    }

    public function testEnqueueScriptsThrowErrorWhenNotGivenAnArray()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();
        $this->expectException(\TypeError::class);
        $assetsService->enqueueScripts('not_an_array');
    }

    public function testEnqueueStylesThrowErrorWhenNotGivenAnArray()
    {

        $assetsService = \Mockery::mock(AssetsService::class)->makePartial();
        $this->expectException(\TypeError::class);
        $assetsService->enqueueStyles('not_an_array');
    }
}
