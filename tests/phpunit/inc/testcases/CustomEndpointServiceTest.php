<?php

declare(strict_types=1);

namespace Tests\Inc\Testcases;

use Includes\Config;
use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use Tests\Inc\CERVTestCase;
use Includes\Services\CustomEndpointService;
use Includes\Services\API\HttpClientService;

class CustomEndpointServiceTest extends CERVTestCase
{

    public function setUp(): void
    {

        parent::setUp();
    }

    public function testInitializeAddActions()
    {

        Config::init();

        Actions\expectAdded('init')->twice();
        Actions\expectAdded('template_redirect')->once();

        ( new CustomEndpointService() )->initialize();

        self::assertTrue(has_action('init', '\Includes\Services\CustomEndpointService->customEnpointRewriteRule()'));
        self::assertTrue(has_action('init', '\Includes\Services\CustomEndpointService->customRewriteTag()'));
        self::assertTrue(has_action('template_redirect', '\Includes\Services\CustomEndpointService->overrideTemplate()'));
    }

    public function testCustomRewriteTagAddsTheCorrectTag()
    {

        Config::init();

        Functions\expect('add_rewrite_tag')
            ->times(1)
            ->with("%cerv_endpoint%", '([^&]+)');

        ( new CustomEndpointService() )->customRewriteTag();
    }

    public function testCustomEnpointRewriteRuleAddDynamicEndpointIfOptionExists()
    {

        Config::init();

        $test = new CustomEndpointService();
        $test->initialize(); // The initialize is needed to populate the defaultEndpoint
        
        $dummyDynamicEndpoint = "my-endpoint";

        Functions\expect('get_option')
            ->with('asdfasdfasdfas')
            ->times(1)
            ->andReturn($dummyDynamicEndpoint);

        Functions\when('esc_attr')
            ->justReturn($dummyDynamicEndpoint);

        Functions\expect('add_rewrite_rule')
            ->times(1)
            ->with("^{$dummyDynamicEndpoint}$", 'index.php?cerv_endpoint=1', 'top');

        Functions\expect('flush_rewrite_rules')
            ->times(1);

        $test->customEnpointRewriteRule();
    }

    public function testCustomEnpointRewriteRuleAddDefaultEndpointIfOptionDoesNotExists()
    {

        Config::init();

        $test = new CustomEndpointService();
        $test->initialize(); // The initialize is needed to populate the defaultEndpoint

        $defaultEndpoint = Config::get('defaultEndpoint');

        Functions\expect('get_option')
            ->with('asdfasdfasdfas')
            ->times(1)
            ->andReturn(null);

        Functions\when('esc_attr')
            ->justReturn(null);

        Functions\expect('add_rewrite_rule')
            ->times(1)
            ->with("^{$defaultEndpoint}$", 'index.php?cerv_endpoint=1', 'top');

        Functions\expect('flush_rewrite_rules')
            ->times(1);

        $test->customEnpointRewriteRule();
    }
    

    public function testOverrideTemplateRenderTheEndpointTemplateIfQueryVarIsDetected()
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

    public function testRenderEndpointTemplateRendersTheUserSelectedTemplateIfResourceHasNoError()
    {

        Config::init();
        Functions\when('wp_enqueue_script')->justReturn(true);
        Functions\when('wp_enqueue_style')->justReturn(true);

        // Assume that the user selected resource is 'users'
        $selectedResource = 'users';
        Functions\expect('get_option')
            ->with('resource_select')
            ->times(1)
            ->andReturn($selectedResource);
        
        Functions\expect('esc_attr')
            ->with($selectedResource)
            ->times(1)
            ->andReturn($selectedResource);

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
            ->with($selectedResource)
            ->andReturn(
                $fakeResource
            );

        // Should load users template
        $templateName = "{$selectedResource}.php";
        $templateResource = ['title' => ucfirst($selectedResource), 'data' => $fakeResource['data']];
        $ceService->shouldReceive('loadTemplate')
            ->once()
            ->with($templateName, $templateResource)
            ->andReturn(Config::get('pluginTemplatePath') . $templateName);

        HttpClientService::changeDevMode(true); // Used only to bypass an SSL error in testing
        $ceService->renderEndpointTemplate();
    }

    public function testRenderEndpointTemplateRendersTheErrorTemplateIfResourceHasErrors()
    {

        Config::init();
        Functions\when('wp_enqueue_script')->justReturn(true);
        Functions\when('wp_enqueue_style')->justReturn(true);
        Functions\when('get_option')->justReturn('users');
        Functions\when('esc_attr')->justReturn('users');

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

    public function testRenderEndpointTemplateRendersThePostsTemplateIfUserSelectedResourceIsSetToPosts()
    {

        Config::init();
        Functions\when('wp_enqueue_script')->justReturn(true);
        Functions\when('wp_enqueue_style')->justReturn(true);

        // Assume that the user selected resource is 'posts'
        $selectedResource = 'posts';
        Functions\expect('get_option')
            ->with('resource_select')
            ->times(1)
            ->andReturn($selectedResource);
        
        Functions\expect('esc_attr')
            ->with($selectedResource)
            ->times(1)
            ->andReturn($selectedResource); 
        

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
            ->with($selectedResource)
            ->andReturn(
                $fakeResource
            );

        // Should load users template
        $templateName = "{$selectedResource}.php";
        $templateResource = ['title' => ucfirst($selectedResource), 'data' => $fakeResource['data']];
        $ceService->shouldReceive('loadTemplate')
            ->once()
            ->with($templateName, $templateResource)
            ->andReturn(Config::get('pluginTemplatePath') . $templateName);

        HttpClientService::changeDevMode(true); // Used only to bypass an SSL error in testing
        $ceService->renderEndpointTemplate();
    }

    public function testRenderEndpointTemplateRendersThePhotosTemplateIfUserSelectedResourceIsSetToPhotos()
    {

        Config::init();
        Functions\when('wp_enqueue_script')->justReturn(true);
        Functions\when('wp_enqueue_style')->justReturn(true);

        // Assume that the user selected resource is 'photos'
        $selectedResource = 'photos';
        Functions\expect('get_option')
            ->with('resource_select')
            ->times(1)
            ->andReturn($selectedResource);
        
        Functions\expect('esc_attr')
            ->with($selectedResource)
            ->times(1)
            ->andReturn($selectedResource); 
        

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
            ->with($selectedResource)
            ->andReturn(
                $fakeResource
            );

        // Should load users template
        $templateName = "{$selectedResource}.php";
        $templateResource = ['title' => ucfirst($selectedResource), 'data' => $fakeResource['data']];
        $ceService->shouldReceive('loadTemplate')
            ->once()
            ->with($templateName, $templateResource)
            ->andReturn(Config::get('pluginTemplatePath') . $templateName);

        HttpClientService::changeDevMode(true); // Used only to bypass an SSL error in testing
        $ceService->renderEndpointTemplate();
    }
}
