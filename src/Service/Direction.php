<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;

class Direction
{
    private string $key;
    private const STATUS = 200;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getDirection(string $start, string $end): array
    {
        $content = [];
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://api.openrouteservice.org/v2/directions/driving-car',
            [
                'query' => [
                    'api_key' => $this->key,
                    'start' => $start,
                    'end' => $end
                ]
            ]
        );
        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === self::STATUS) {
            $content = $response->getContent();
            // get the response in JSON format

            $content = $response->toArray();
            // convert the response (here in JSON) to an PHP array
            return $content['features'][0]['geometry']['coordinates'];
        }

        throw new Exception('Le service est temporairement indisponible');
    }
}
