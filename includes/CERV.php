<?php

declare(strict_types=1);

namespace Includes;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

final class CERV
{
    /**
     * Runs the CERV plugin and initializes all available services
     * @return void
     */
    public static function run()
    {
        Config::init();
        self::initializeService(Services\AssetsService::class);
        self::initializeService(Services\CustomEndpointService::class);
    }
 
    /**
     * Creates a new intance of the service and executes its initialize method
     * @return void
     */
    public static function initializeService(string $class)
    {
        $service = new $class();
        $service->initialize();
    }
}
