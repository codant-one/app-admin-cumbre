<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

use Google\Client;

use GuzzleHttp\Exception\RequestException;
use Carbon\Carbon;

class GoogleFirebaseConsole
{
    protected $client;
    protected $accessToken;
    protected $url;

    public function __construct()
    {
        $this->url = 'https://fcm.googleapis.com/v1/projects/'.env('GOOGLE_FIREBASE_PROJECT_ID').'/messages:send';
        
        $this->client = new Client();
        $this->client->setAuthConfig(storage_path('app/google-credentials.json'));
        $this->client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        
        $token =  $this->client->fetchAccessTokenWithAssertion();

        if (!isset($token['access_token'])) {
            $this->accessToken = false;
        } else {
            $this->accessToken = $token['access_token'];
        }

    }

    function pushNotification($fcmToken, $title, $body, $user) {
        
        try {

            $headers = [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '. $this->accessToken
            ];

            $client = new \GuzzleHttp\Client();

            $payload = [
                'message' => [
                    'token' => $fcmToken,  // El token del dispositivo
                    'notification' => [
                        'title' => $title,  // Título de la notificación
                        'body' => $body    // Cuerpo de la notificación
                    ],
                    'data' => [  // Datos adicionales
                        'action' => 'open_app',
                        'device_type' => $user->device_type
                    ],
                ],
            ];

            $options = [
                'headers' => $headers,
                'json' => $payload,
            ];

            // Log::info('url '. $this->url);
            // Log::info('$options '. json_encode($options));

            $response = $client->post($this->url, $options);
            $responseJson = json_decode($response->getBody(), true);

            Log::info('$response '. $response);
            Log::info($responseJson);
            return [
                'data' => $responseJson,
                'success' => true
            ];

        } catch (RequestException $e) {
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
