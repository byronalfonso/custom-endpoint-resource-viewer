<?php
namespace Includes\Services\API;

use Includes\Config;
use Includes\Services\API\APIRequestService;

class ResourceService
{    
    private $client;
    private $resourcePath;

    public function __construct(){
        $this->setResourcePath('https://jsonplaceholder.typicode.com');
        $this->client = new APIRequestService($this->resourcePath); // move base path to config later
    }

    public function setResourcePath($resourcePath){
        $this->resourcePath = $resourcePath;
    }

    public function getResourcePath(){
        return $this->resourcePath;
    }

    public function getResource(String $resource){
        $this->client->_GET($resource);
    }
}
