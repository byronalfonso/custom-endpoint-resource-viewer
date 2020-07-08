<?php

declare(strict_types=1);

namespace Includes;

final class Config
{
    private static $config;

    /**
     * Initialize all plugin-wide config and vars
     * @return void
     */
    public static function init()
    {

        $basePath = plugin_dir_path(dirname(__FILE__));
        $baseUrl = plugin_dir_url(dirname(__FILE__));
        self::$config = [
            'pluginPath' => $basePath,
            'pluginUrl' => $baseUrl,
            'pluginTemplatePath' => $basePath . 'templates/',
            'pluginAssetsUrl' => $baseUrl . 'assets/',
            'defaultEndpoint' => 'cerv',
            'defaultAPIEnpoint' => 'https://jsonplaceholder.typicode.com',
            'cacheExpiration' => 60, //in seconds
        ];
    }
    
    /**
     * Gets the config by its key
     * @return string $config[$key]
     */
    public static function get(string $key): string
    {
        if (empty(self::$config[$key])) {
            throw new Exception("Invalid config key.");
        }

        return self::$config[$key];
    }
}
