<?php

use \Includes\CERV;
use \Includes\Config;
use \Brain\Monkey\Functions;
use \Includes\Services\API\ResourceService;

class CERVTest extends \CERVTestCase {

    public function setUp(): void {
        parent::setUp();
    }

    public function test_run_initializes_the_plugin_services(){        
        // Initialized services should be none before running the CERV plugin.
        $this->assertEquals( 0, count( CERV::getInitializedServices() ) );
        
        // Run the plugin
        CERV::run();

        // After running the plugin, the initialized services should be 2 (2 are currently statically set inside CERV class)
        $this->assertEquals( 2, count( CERV::getInitializedServices() ) );

        // Make sure that the initialized plugin services are correct
        $pluginServices = CERV::getInitializedServices();        
        $this->assertEquals( in_array(Includes\Services\AssetsService::class, $pluginServices), true );
        $this->assertEquals( in_array(Includes\Services\CustomEndpointService::class, $pluginServices), true );

        // Make sure that the initialized plugin are a child of the PluginServiceInterface.
        foreach ($pluginServices as $service) {
            $this->assertEquals(
                (new $service() instanceof Includes\Interfaces\PluginServiceInterface),
                true
            );
        }
    }

    public function test_run_initializes_config(){
        // Run the plugin
        CERV::run();

        // Verify that some values from the Config has been initialized and changed
        $this->assertEquals( $this->dummyPluginDirPath, Config::get('pluginPath') );
        $this->assertEquals( $this->dummyPluginDirUrl, Config::get('pluginUrl') );
        $this->assertEquals( $this->dummyTemplateDir . 'templates/', Config::get('themeTemplatePath') );
    }
    
    public function test_initializeServices_throw_error_when_not_given_a_plugin_service_interface(){
        // Run the plugin
        CERV::run();
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid service initialization. Includes\Services\API\ResourceService must be an instance of the PluginServiceInterface.");

        // ResourceService is not an instance of the PluginServiceInterface, thus the function should throw an error
        CERV::initializeServices([            
            Includes\Services\API\ResourceService::class
        ]);
    }

    public function test_initializeServices_ignore_services_that_are_already_initialized(){        
        // Run the plugin
        CERV::run();
        
        // There should be 2 initialized plugin service
        $this->assertEquals( 2, count( CERV::getInitializedServices() ) );
        
        // Initialized the same services
        CERV::initializeServices([            
            Includes\Services\AssetsService::class,
            Includes\Services\CustomEndpointService::class
        ]);

        // Initialized services should be the same
        $this->assertEquals( 2, count( CERV::getInitializedServices() ) );
    }
}
