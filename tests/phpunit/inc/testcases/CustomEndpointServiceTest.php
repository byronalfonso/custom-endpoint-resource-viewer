<?php

use \Includes\CERV;
use \Includes\Config;
use \Brain\Monkey\Functions;
use \Brain\Monkey\Actions;
use \Includes\Services\CustomEndpointService;
use \Includes\Services\API\ResourceService;

class CustomEndpointServiceTest extends \CERVTestCase {

    public function test_initialize_add_actions(){
        Config::init();

        Actions\expectAdded('init')->twice();
        Actions\expectAdded('template_redirect')->once();

        ( new CustomEndpointService() )->initialize();

        self::assertTrue( has_action('init', '\Includes\Services\CustomEndpointService->customEnpointRewriteRule()') );
        self::assertTrue( has_action('init', '\Includes\Services\CustomEndpointService->customRewriteTag()') );
        self::assertTrue( has_action('template_redirect', '\Includes\Services\CustomEndpointService->overrideTemplate()') );
    }


    public function test_customRewriteTag_adds_the_corrects_tag(){
        Config::init();

        Functions\expect('add_rewrite_tag')
            ->times(1)
            ->with("%cerv_endpoint%", '([^&]+)');

        ( new CustomEndpointService() )->customRewriteTag();
    }
    
    
}

