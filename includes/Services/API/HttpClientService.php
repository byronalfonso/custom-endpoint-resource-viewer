<?php

namespace Includes\Services\API;

use Exception;
use Includes\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\ResponseInterface;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Doctrine\Common\Cache\FilesystemCache;
use Kevinrob\GuzzleCache\Strategy\PrivateCacheStrategy;
use Kevinrob\GuzzleCache\Storage\DoctrineCacheStorage;

class HttpClientService
{
    private $baseUri;
    private $client;

    public function __construct($baseUri = null)
    {

        if ($baseUri) {
            $this->validateUrl($baseUri);
            $this->baseUri = $baseUri;
        }
        
        // Setup caching mechanism
        $stack = HandlerStack::create();
        $stack->push(new CacheMiddleware(new PrivateCacheStrategy(new DoctrineCacheStorage(new FilesystemCache('/tmp/')), Config::get('cacheExpiration'))), 'cache');
// Initialize the client with the handler option
        $this->client = new Client(['handler' => $stack]);
    }

    public function _GET(string $url)
    {
        try {
            $endpoint = $this->baseUri . $url;
            $response = $this->request('GET', $endpoint);
            return $this->prepareResponse($response);
        } catch (Exception $e) {
            return [
                "status" => "error", "error" => $e->getMessage(),
            ];
        }
    }

    public function _POST(string $url)
    {
        // In theory this class should support other REST operations
    }

    public function _PUT(string $url)
    {
        // In theory this class should support other REST operations
    }

    public function _PATCh(string $url)
    {
        // In theory this class should support other REST operations
    }

    private function validateUrl($url)
    {

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Unable to process your request", 1);
        }
    }

    private function request($method, $endpoint)
    {
        $request = new Request($method, $endpoint);
        return $this->client->sendAsync($request)
            ->then(static function (ResponseInterface $res) {

                    return $res;
            }, static function (Exception $e) {

                    throw new Exception($e->getMessage());
            })
            ->wait();
    }

    
    private function prepareResponse($response)
    {

        if (empty($response)) {
            return -1;
        }

        return [
            "status" => "success", "data" => json_decode($response->getBody(), true),
        ];
    }
}
