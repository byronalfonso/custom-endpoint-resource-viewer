<?php

declare(strict_types=1);

namespace Tests\Inc\Testcases;

use Includes\Config;
use Tests\Inc\CERVTestCase;
use Brain\Monkey\Functions;

class ConfigTest extends CERVTestCase
{

    public function testInitInitializesTheConfig()
    {

        Config::init();

        // The config should have items in it after init
        $config = Config::all();
        $this->assertTrue(count($config) > 0);
    }

    
    public function testGetReturnsCorrectValuesForExistingAndValidConfigKeys()
    {

        Config::init();

        // Verify that it returns the correct values for known keys
        $this->assertEquals($this->dummyPluginDirPath, Config::get('pluginPath'));
        $this->assertEquals($this->dummyPluginDirUrl, Config::get('pluginUrl'));
        $this->assertEquals($this->dummyTemplateDir . 'templates/', Config::get('themeTemplatePath'));
    }

    public function testGetThrowsErrorForInvalidConfigKeys()
    {

        Config::init();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Invalid config key.");

        Config::get('non existing key');
        Config::get('invalid');
    }

    public function testGetAllReturnsAllConfig()
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
            'defaultResource',
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
