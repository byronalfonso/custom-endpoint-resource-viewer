<?php
namespace Includes;

class Config
{	
    private static $config;

    public static function init(){
        $basePath = plugin_dir_path( dirname(__FILE__) );

        self::$config = array(
            'pluginPath' => $basePath,
            'templatePath' => $basePath . 'templates/',
            'defaultEndpoint' => 'cerv'
        );
    }
    
    public static function get(String $key){
        if(self::$config[$key]){
            return self::$config[$key];
        }

        return -1;
    }
}

Config::init();