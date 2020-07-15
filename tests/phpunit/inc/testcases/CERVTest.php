<?php

use \Includes\CERV;
use \Includes\Config;
use \Brain\Monkey\Functions;

class CERVTest extends \CERVTestCase {

    public function test_run_initializes_config(){        
        $dummyPluginDirPath = 'plugins/';
        $dummyPluginDirUrl = 'plugins/cerv';
        $dummyTemplateDir = 'themes/';        

        Functions\when( 'plugin_dir_path' )
            ->justReturn( $dummyPluginDirPath );
        
        Functions\when( 'plugin_dir_url' )
            ->justReturn( $dummyPluginDirUrl );

        Functions\when( 'get_template_directory' )
            ->justReturn( $dummyTemplateDir );
        
        
        // Run the plugin
        ( new CERV() )->run();

        // Check some values from the Config
        $this->assertEquals( $dummyPluginDirPath, Config::get('pluginPath') );
        $this->assertEquals( $dummyPluginDirUrl, Config::get('pluginUrl') );
        $this->assertEquals( $dummyTemplateDir . 'templates/', Config::get('themeTemplatePath') );
    }
}

