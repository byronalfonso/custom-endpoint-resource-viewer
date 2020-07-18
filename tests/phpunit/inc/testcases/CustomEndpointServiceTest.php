<?php

use Includes\Config;
use Brain\Monkey\Functions;
use Brain\Monkey\Actions;
use Includes\Services\CustomEndpointService;
use Includes\Services\API\HttpClientService;

class CustomEndpointServiceTest extends \CERVTestCase
{

    public function test_initialize_add_actions()
    {

        Config::init();

        Actions\expectAdded('init')->twice();
        Actions\expectAdded('template_redirect')->once();

        ( new CustomEndpointService() )->initialize();

        self::assertTrue(has_action('init', '\Includes\Services\CustomEndpointService->customEnpointRewriteRule()'));
        self::assertTrue(has_action('init', '\Includes\Services\CustomEndpointService->customRewriteTag()'));
        self::assertTrue(has_action('template_redirect', '\Includes\Services\CustomEndpointService->overrideTemplate()'));
    }

    public function test_customRewriteTag_adds_the_correct_tag()
    {

        Config::init();

        Functions\expect('add_rewrite_tag')
            ->times(1)
            ->with("%cerv_endpoint%", '([^&]+)');

        ( new CustomEndpointService() )->customRewriteTag();
    }

    public function test_customEnpointRewriteRule_add_the_correct_rule()
    {

        Config::init();

        $test = new CustomEndpointService();
        $test->initialize(); // The initialize is needed to populate the defaultEndpoint

        $defaultEndpoint = Config::get('defaultEndpoint');

        Functions\expect('add_rewrite_rule')
            ->times(1)
            ->with("^{$defaultEndpoint}$", 'index.php?cerv_endpoint=1', 'top');

        Functions\expect('flush_rewrite_rules')
            ->times(1);

        $test->customEnpointRewriteRule();
    }
    

    public function test_overrideTemplate_render_the_endpoint_template_if_query_var_is_detected()
    {

        Functions\expect('get_query_var')
            ->with('cerv_endpoint')
            ->times(1)
            ->andReturn(true);

        $ceService = \Mockery::mock(CustomEndpointService::class)->makePartial();
        
        $ceService->shouldReceive('renderEndpointTemplate')
            ->once()
            ->andReturn(1);

        $ceService->shouldReceive('exit')
            ->once()
            ->andReturn(1);

        $ceService->overrideTemplate();
    }

    public function test_renderEndpointTemplate_renders_the_custom_template_if_resource_has_no_error()
    {

        Config::init();
        Functions\when('wp_enqueue_script')->justReturn(true);
        Functions\when('wp_enqueue_style')->justReturn(true);

        $ceService = \Mockery::mock(CustomEndpointService::class)->makePartial();

        // Should load assets
        $ceService->shouldReceive('loadAssets')->once();

        // Should load resources
        $fakeResource = [
            "status" => "success",
            "data" => [],
            "hasErrors" => false,
        ];
        $ceService->shouldReceive('loadResource')
            ->once()
            ->with('users')
            ->andReturn(
                $fakeResource
            );

        // Should load template
        $templateName = 'custom.php';
        $templateResource = ['title' => 'Users', 'data' => $fakeResource['data']];
        $ceService->shouldReceive('loadTemplate')
            ->once()
            ->with($templateName, $templateResource)
            ->andReturn(Config::get('pluginTemplatePath') . $templateName);

        HttpClientService::changeDevMode(true); // Used only to bypass an SSL error in testing
        $ceService->renderEndpointTemplate();
    }

    public function test_renderEndpointTemplate_renders_the_error_template_if_resource_has_errors()
    {

        Config::init();
        Functions\when('wp_enqueue_script')->justReturn(true);
        Functions\when('wp_enqueue_style')->justReturn(true);

        $ceService = \Mockery::mock(CustomEndpointService::class)->makePartial();

        // Should load assets
        $ceService->shouldReceive('loadAssets')->once();

        // Should load resources
        $fakeErrorResource = [
            "status" => "error",
            "error" => "Error loading resource",
            "hasErrors" => true,
        ];

        $ceService->shouldReceive('loadResource')
            ->once()
            ->with('users')
            ->andReturn(
                $fakeErrorResource
            );

        // Should load error template
        $templateName = 'error.php';
        $ceService->shouldReceive('loadTemplate')
            ->once()
            ->with($templateName, $fakeErrorResource)
            ->andReturn(Config::get('pluginTemplatePath') . $templateName);

        HttpClientService::changeDevMode(true); // Used only to bypass an SSL error in testing
        $ceService->renderEndpointTemplate();
    }
}
