<?php
namespace Includes;

class Config
{	
    private static $pluginPath;
    private static $templatePath;

    public static function init(){
        self::$pluginPath = plugin_dir_path( dirname(__FILE__) );
        self::$templatePath = self::$pluginPath . 'templates/';
    }

	public static function pluginPath(){
        return self::$pluginPath;
	}

	public static function templatePath(){
        return self::$templatePath;
	}
}

Config::init();