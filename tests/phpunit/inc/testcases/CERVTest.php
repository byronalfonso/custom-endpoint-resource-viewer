<?php

use \Includes\CERV;
use \Includes\Config;
use \Brain\Monkey\Functions;

class CERVTest extends \CERVTestCase {

    private $dummyPluginDirPath = 'plugins/';
    private $dummyPluginDirUrl = 'plugins/cerv';
    private $dummyTemplateDir = 'themes/'; 


    public function setUp(): void {
        parent::setUp();

        Functions\when( 'plugin_dir_path' )
            ->justReturn( $this->dummyPluginDirPath );
        
        Functions\when( 'plugin_dir_url' )
            ->justReturn( $this->dummyPluginDirUrl );

        Functions\when( 'get_template_directory' )
            ->justReturn( $this->dummyTemplateDir );
    }

    public function test_run_initializes_config(){        
        // Run the plugin
        ( new CERV() )->run();

        // Check some values from the Config
        $this->assertEquals( $this->dummyPluginDirPath, Config::get('pluginPath') );
        $this->assertEquals( $this->dummyPluginDirUrl, Config::get('pluginUrl') );
        $this->assertEquals( $this->dummyTemplateDir . 'templates/', Config::get('themeTemplatePath') );
    }
}

