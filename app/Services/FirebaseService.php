<?php

namespace App\Services;

use Google\Client;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Cache;


class FirebaseService
{
    protected $client;

    protected string $projectId;


    public function __construct()
    {
        $this->projectId = env('FIREBASE_PROJECT_ID');
    }

    public function sendNotification(string $token, array $data)
    {
        // Get access token (cached)

        Log::info('Notification Data', [
            'token' => $token,
            'data'  => $data,
        ]);

        $accessToken = Cache::remember('fcm_access_token', 55 * 60, function () {
            Log::debug('⚡ Generating NEW FCM Access Token');

            $credentials = new ServiceAccountCredentials(
                ['https://www.googleapis.com/auth/firebase.messaging'],
                storage_path('app/firebase.json')
            );


            $token = $credentials->fetchAuthToken();

            return $token['access_token'] ?? null;
        });

        Log::debug('✔ Using FCM Access Token: '.$accessToken);

        // Build payload directly
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $data['title'] ?? '',
                    'body' => $data['body'] ?? '',
                ],
                'data' => [
                    'title' => $data['title'] ?? '',
                    'body' => $data['body'] ?? '',
                    // 'link' => $data['link'] ?? 'https://onstru.com/',
                    // 'id' => (string) ($data['id'] ?? ''),
                ],
            ],
        ];

        $url = "https://fcm.googleapis.com/v1/projects/{$this->projectId}/messages:send";

        $response = Http::withToken($accessToken)->post($url, $payload);

        
        return $response;
        // return $response->json();
        }



}
