<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;

class Matrix
{
    private string $key;
    private const STATUS = 200;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getMatrix(): ?array
    {
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
                    'coordinates' => [[2.3488,48.8534],[2.8667,48.95]],
                    'preference' => 'shortest'
                ]
            ]
        );

        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === self::STATUS) {
            // associative array (distances and durations)

            return $response->toArray();
        }
        throw new Exception('Le service est temporairement indisponible');
    }
}
