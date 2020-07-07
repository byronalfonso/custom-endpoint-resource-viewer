<?php
namespace Includes;

final class Config
{	
    private static $config;

    /**
	 * Initialize all plugin-wide config and vars
	 * @return void
	 */
    public static function init(){
        $basePath = plugin_dir_path( dirname(__FILE__) );
        $baseUrl = plugin_dir_url( dirname(__FILE__) );

        self::$config = array(
            'pluginPath' => $basePath,
            'pluginUrl' => $baseUrl,
            'pluginTemplatePath' => $basePath . 'templates/',
            'pluginAssetsUrl' => $baseUrl . 'assets/',
            'defaultEndpoint' => 'cerv',
            'defaultAPIEnpoint' => 'https://jsonplaceholder.typicode.com',
        );
    }
    
    /**
	 * Gets the config by its key
	 * @return $config[$key] - string
	 */
    public static function get(String $key){
        if(self::$config[$key]){
            return self::$config[$key];
        }

        return -1;
    }
}

Config::init();