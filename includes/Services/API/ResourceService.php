<?php

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

    private function setResourcePath($resourcePath)
    {

             $this->resourcePath = $resourcePath;
    }

    public function getResourcePath()
    {

             return $this->resourcePath;
    }

    public function getResource(string $resource)
    {

             $resource = $this->client->GET($resource);
        $resource['hasErrors'] = false;
        if (isset($resource['error'])) {
            $resource['hasErrors'] = true;
            return $resource;
        }

        return $resource;
    }
}
