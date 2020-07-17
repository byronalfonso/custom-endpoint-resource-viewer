<?php

declare(strict_types=1);

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
    private $requestOptions = [];
    private static $devMode = false;

    public function __construct(string $baseUri = null)
    {

        if ($baseUri) {
            $this->validateUrl($baseUri);
            $this->baseUri = $baseUri;
        }
        
        // Setup caching mechanism
        $stack = HandlerStack::create();
        $stack->push(
            new CacheMiddleware(
                new PrivateCacheStrategy(
                    new DoctrineCacheStorage(
                        new FilesystemCache('/tmp/')
                    ),
                    Config::get('cacheExpiration')
                )
            ),
            'cache'
        );
        
        // Initialize the client with the handler option
        $this->client = new Client(['handler' => $stack]);
    }

    public function setRequestOptions(array $options){
        $this->requestOptions = $options;
    }

    public function GET(string $url): array
    {
        try {
            $endpoint = $this->baseUri . $url;
            $response = $this->request('GET', $endpoint);
            return $this->prepareResponse($response);
        } catch (Exception $error) {
            return [
                "status" => "error", "error" => $error->getMessage(),
            ];
        }
    }

    public function POST(string $url)
    {
        // In theory this class should support other REST operations
    }

    public function PUT(string $url)
    {
        // In theory this class should support other REST operations
    }

    public function PATCH(string $url)
    {
        // In theory this class should support other REST operations
    }

    public static function setDevMode(bool $mode = false){
        self::$devMode = $mode;
    }

    private function validateUrl(string $url)
    {

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            throw new Exception("Unable to process your request", 1);
        }
    }

    private function request(string $method, string $endpoint, array $options = []): object
    {
        // Allow the options to be overriden
        if(is_array($options) && !empty($options)){
            $this->requestOptions = $options;
        }

        // Disable SSL verification if set to true; Note: Currently used to bypass SSL error in testing
        if(self::$devMode){
            $this->requestOptions = array_merge($this->requestOptions, ['verify' => false]);
        }

        // Send the actual request
        $request = new Request($method, $endpoint);
        return $this->client->sendAsync($request, $this->requestOptions)
            ->then(static function (ResponseInterface $res): object {
                return $res;
            }, static function (Exception $error) {
                throw new Exception($error->getMessage());
            })
            ->wait();
    }

    
    private function prepareResponse(object $response): array
    {
        if (empty($response)) {
            throw new Exception("Error: Empty response object found.", 1);
        }
        
        return [
            "status" => "success", "data" => json_decode(strval($response->getBody()), true),
        ];
    }
}
