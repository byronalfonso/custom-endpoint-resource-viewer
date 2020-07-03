<?php
namespace Includes;

final class CERV
{
	/**
	 * Runs the CERV plugin and initializes all available services
	 * @return void
	 */
	public static function run(){		
        self::initializeService(Services\CustomEndpointService::class);
	}

	public static function initializeService($class){
		$service = new $class();
		$service->initialize();
	}
}
