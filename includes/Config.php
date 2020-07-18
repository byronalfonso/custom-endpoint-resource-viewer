<?php

declare(strict_types=1);

namespace Includes;

final class Config
{
    private static $config = [];

    /**
     * Initialize all plugin-wide config and vars
     * @return void
     */
    public static function init()
    {

        $basePath = plugin_dir_path( dirname(__FILE__) );
        $baseUrl = plugin_dir_url( dirname(__FILE__) );        
        $pluginName = plugin_basename( dirname( __FILE__, 2 ) ) . '/custom-endpoint-resource-viewer.php';
        
        self::$config = [
            'pluginName' => $pluginName,
            'pluginPath' => $basePath,
            'pluginUrl' => $baseUrl,
            'pluginTemplatePath' => $basePath . 'templates/',
            'themeTemplatePath' => get_template_directory() . 'templates/',
            'pluginAssetsUrl' => $baseUrl . 'assets/',
            'defaultEndpoint' => 'cerv',
            'defaultAPIEnpoint' => 'https://jsonplaceholder.typicode.com',
            'cacheExpiration' => '60', //in seconds
            'settingsNonceKey' => 'settings_page_nonce'
        ];
    }
    
    /**
     * Gets the config by its key
     * @return string $config[$key]
     */
    public static function get(string $key): string
    {
        if (empty(self::$config[$key])) {
            throw new \Exception("Invalid config key.");
        }

        return self::$config[$key];
    }

    /**
     * Gets the all config
     * @return array $config
     */
    public static function getAll(): array
    {
        return self::$config;
    }
}
