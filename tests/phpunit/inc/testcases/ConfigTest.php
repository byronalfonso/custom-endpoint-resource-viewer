<?php

use Includes\Config;
use Brain\Monkey\Functions;

class ConfigTest extends \CERVTestCase
{

    public function test_init_initializes_the_config()
    {

        Config::init();

        // The config should have items in it after init
        $config = Config::all();
        $this->assertTrue(count($config) > 0);
    }

    
    public function test_get_returns_correct_values_for_existing_and_valid_config_keys()
    {

        Config::init();

        // Verify that it returns the correct values for known keys
        $this->assertEquals($this->dummyPluginDirPath, Config::get('pluginPath'));
        $this->assertEquals($this->dummyPluginDirUrl, Config::get('pluginUrl'));
        $this->assertEquals($this->dummyTemplateDir . 'templates/', Config::get('themeTemplatePath'));
    }

    public function test_get_throws_error_for_invalid_config_keys()
    {

        Config::init();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid config key.");

        Config::get('non existing key');
        Config::get('invalid');
    }

    public function test_getAll_returns_all_config()
    {

        Config::init();

        // All valid and existing config keys
        $validKeys = [
            'pluginName',
            'pluginPath',
            'pluginUrl',
            'pluginTemplatePath',
            'themeTemplatePath',
            'pluginAssetsUrl',
            'defaultEndpoint',
            'defaultAPIEnpoint',
            'cacheExpiration',
            'settingsNonceKey',
        ];

        $config = Config::all();

        // All valid keys must be present from the returned config
        foreach ($validKeys as $key) {
            $this->assertTrue(array_key_exists($key, $config));
        }
    }
}
