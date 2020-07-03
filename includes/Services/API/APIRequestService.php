<?php
namespace Includes\Services\API;

use Exception;
use Includes\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;

class APIRequestService
{
    private $baseUri;
    private $client;

    public function __construct($baseUri = null){
        if($baseUri){
            $this->validateUrl($baseUri);
            $this->baseUri = $baseUri;
        }
        $this->client = new Client();
    }

	public function _GET(String $url)
	{
        $endpoint = $this->baseUri . $url;
        $response = $this->request('GET', $endpoint);
        return $this->prepareResponse($response);
    }

    public function _POST(String $url)
	{
        // In theory this class should support other REST operations
    }

    public function _PUT(String $url)
	{
        // In theory this class should support other REST operations
    }

    public function _PATCh(String $url)
	{
        // In theory this class should support other REST operations
    }

    private function validateUrl($url){
        if ( !filter_var($url, FILTER_VALIDATE_URL) ) {
            throw new Exception("Unable to process your request", 1);
        }
    }

    private function request($method, $endpoint)
	{
        $request = new Request($method, $endpoint);
        return $this->client->sendAsync($request)
            ->then(
                function (ResponseInterface $res) {
                    return $res;
                },
                function (RequestException $e) {
                    return $e->getResponse();
                }
            )
            ->wait();
    }
    
    private function prepareResponse($response){
        return json_decode($response->getBody(), true);
    }
}
