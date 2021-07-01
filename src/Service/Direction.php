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

    public function getDirection(
        array $homeCoordinate,
        array $workCoordinate,
        string $preference = 'recommended'
    ): ?array {
        $coordinates[] = $homeCoordinate;
        $coordinates[] = $workCoordinate;

        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            'https://api.openrouteservice.org/v2/directions/driving-car/geojson',
            [
                'headers' => [
                    'Accept' => 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8',
                    'Authorization' => $this->key,
                    'Content-Type' => 'application/json; charset=utf-8'
                ],
                'json' => [
                    'coordinates' => $coordinates,
                    'preference' => $preference

                ]
            ]
        );

        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === self::STATUS) {
            // associative array (distances and durations)
            $content = $response->toArray()['features'][0];

            return $content;
        }
        throw new Exception('Le service est temporairement indisponible');
    }
}
