<?php

namespace App\Services;

use GuzzleHttp\Client;
use Exception;

class ImageService
{
    public function getRandomImage(string $query = 'writing'): ?string
    {
        try {
            $client = new Client();

            $response = $client->get('https://api.unsplash.com/photos/random', [
                'query' => [
                    'query' => $query,
                    'orientation' => 'landscape',
                ],
                'headers' => [
                    'Authorization' => 'Client-ID ' . env('UNSPLASH_ACCESS_KEY'),
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            return $data['urls']['regular'] ?? null;
        } catch (Exception $e) {
            return null;
        }
    }
}
