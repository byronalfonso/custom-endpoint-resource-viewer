<?php

declare(strict_types=1);

namespace Includes\Services\API;

use Includes\Config;
use Includes\Services\API\HttpClientService;

class ResourceService
{
    
    private $client;
    private $resourcePath;

    public function __construct()
    {

        $this->setResourcePath(Config::get('defaultAPIEnpoint'));
        $this->client = new HttpClientService($this->resourcePath); // move base path to config later
    }

    private function setResourcePath(string $resourcePath)
    {

        $this->resourcePath = $resourcePath;
    }

    public function resourcePath(): string
    {
        return $this->resourcePath;
    }

    public function fetchResource(string $resource): array
    {
        $resource = $this->client->GET("/{$resource}");
        $resource['hasErrors'] = false;
        if (isset($resource['error'])) {
            $resource['hasErrors'] = true;
            return $resource;
        }

        return $resource;
    }
}
