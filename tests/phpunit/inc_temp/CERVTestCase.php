<?php

declare(strict_types=1);

namespace Tests\Inc;

use Brain\Monkey;
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

/**
 * Base test class for the CERV plugin
 */
class CERVTestCase extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration;

    protected $dummyPluginBaseName = 'cerv';
    protected $dummyPluginDirPath = 'plugins/';
    protected $dummyPluginDirUrl = 'plugins/cerv';
    protected $dummyTemplateDir = 'themes/';

    public function setUp(): void
    {

        parent::setUp();
        Monkey\setUp();
        Monkey\Functions\when('plugin_basename')
            ->justReturn($this->dummyPluginBaseName);
        Monkey\Functions\when('plugin_dir_path')
            ->justReturn($this->dummyPluginDirPath);
        Monkey\Functions\when('plugin_dir_url')
            ->justReturn($this->dummyPluginDirUrl);
        Monkey\Functions\when('get_template_directory')
            ->justReturn($this->dummyTemplateDir);
    }

    
    public function tearDown(): void
    {

        Monkey\tearDown();
        parent::tearDown();
    }
}
