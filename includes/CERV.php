<?php

declare(strict_types=1);

namespace Includes;

use Includes\Config;
use Includes\Interfaces\PluginServiceInterface;

final class CERV
{
    private static $initializedServices = [];

    /**
     * Runs the CERV plugin and initializes all available services
     * @return void
     */
    public static function run()
    {
        Config::init();
        self::initializeServices([
            Services\AssetsService::class,
            Services\CustomEndpointService::class
        ]);
    }

    /**
     * Create instances of all the services and executes their initialize method
     * @return void
     */
    public static function initializeServices($services)
    {
        foreach ($services as $class) {
            // Initialize the service only if it hasn't been initialized yet
            if( in_array($class, self::$initializedServices) ){
                continue;
            }

            // Throw an error if the service is not an instance of PluginServiceInterface
            if ( !is_subclass_of($class, 'Includes\Interfaces\PluginServiceInterface') ) {
                throw new \Exception("Invalid service initialization. " . $class . " must be an instance of the PluginServiceInterface.");
            }
            
            $service = new $class();
            $service->initialize();
            array_push(self::$initializedServices, $class);
        }
    }
    
    /**
     * Gets all the the classnames for all initialized services
     * @return array self::$initializedServices
     */
    public static function getInitializedServices(): array
    {
        return self::$initializedServices;
    }
}
