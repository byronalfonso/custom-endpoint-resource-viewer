<?php
namespace Includes\Services\API;

use Exception;
use Includes\Config;
use GuzzleHttp\Client;

class APIRequestService
{
    private $client;

    public function __construct($baseUri = null){
        if($baseUri){
            $this->validateUrl($baseUri);
        }
        
        $this->client = new Client(['base_uri' => $baseUri]);
    }

	public function _GET(String $url)
	{
        $this->client->request('GET', $url);
    }

    public function _POST(String $url)
	{
        // Add logic if necessary
    }

    public function _PUT(String $url)
	{
        // Add logic if necessary
    }

    public function _PATCh(String $url)
	{
        // Add logic if necessary
    }

    private function validateUrl($url){
        if ( !filter_var($url, FILTER_VALIDATE_URL) ) {
            throw new Exception("Unable to process your request", 1);
        }
    }
}
