<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use Google\Client;

use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

class ExpoHost
{
    protected $client;
    protected $url;

    public function __construct()
    {
        $this->url = 'https://exp.host/--/api/v2/push/send';
        $this->client = new Client();
    }

    function pushNotification($fcmToken, $title, $body, $user) {
        
        try {

            $headers = [
                'Content-Type' => 'application/json',
            ];

            $client = new \GuzzleHttp\Client();

            $payload = [
                'to' => [$fcmToken],
                'title' => $title, 
                'body' => $body 

            ];

            $options = [
                'headers' => $headers,
                'json' => $payload,
            ];

            $response = $client->post($this->url, $options);
            $responseJson = json_decode($response->getBody(), true);

            Log::info($responseJson);
            return [
                'data' => $responseJson,
                'success' => true
            ];

        } catch (RequestException $e) {
            Log::info('error '. $e);
            if ($e->hasResponse()) {
                $errorResponse = json_decode($e->getResponse()->getBody(), true);
                $response = [
                    'data' => $errorResponse,
                    'success' => false
                ];
    
                return $response;
            } else {
                $response = [
                    'data' => 'Ha ocurrido un error',
                    'success' => false
                ];
    
                return $response;
            }
        }
    }

}
