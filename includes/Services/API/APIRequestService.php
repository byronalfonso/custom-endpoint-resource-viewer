<?php
namespace Includes\Services\API;

use Exception;
use Includes\Config;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

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
        try {
			$endpoint = $this->baseUri . $url;
            $response = $this->request('GET', $endpoint);
            return $this->prepareResponse($response);
		} catch (Exception $e) {
            return array(
                "status" => "error",
                "error" => $e->getMessage()
            );
		}
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
                function (Exception $e) {
                    throw new Exception($e->getMessage());
                }
            )
            ->wait();
    }
    
    private function prepareResponse($response){
        if(empty($response)){
            return -1;
        }

        return array(
            "status" => "success",
            "data" => json_decode($response->getBody(), true)
        );
    }
}
