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

    public function getMatrix(array $homeCoordinate, array $workCoordinate, array $futurWorkCoordinate = [0,0]): ?array
    {
        $client = HttpClient::create();
        $response = $client->request(
            'POST',
            'https://api.openrouteservice.org/v2/matrix/driving-car',
            [
                'headers' => [
                    'Accept' => 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8',
                    'Authorization' => $this->key,
                    'Content-Type' => 'application/json; charset=utf-8'
                ],
                'json' => [
                    'locations' => [$homeCoordinate, $workCoordinate, $futurWorkCoordinate],
                    'metrics' => ['distance', 'duration']
                ]
            ]
        );

        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === self::STATUS) {
            // associative array (distances and durations)
            $result = [];
            $result['distances']['homeToWork'] = $response->toArray()['distances'][0][1];
            $result['distances']['workToHome'] = $response->toArray()['distances'][1][0];
            $result['distances']['homeToFuturWork'] = $response->toArray()['distances'][0][2];
            $result['distances']['futurWorkToHome'] = $response->toArray()['distances'][2][0];

            $result['durations']['homeToWork'] = $response->toArray()['durations'][0][1];
            $result['durations']['workToHome'] = $response->toArray()['durations'][1][0];
            $result['durations']['homeToFuturWork'] = $response->toArray()['durations'][0][2];
            $result['durations']['futurWorkToHome'] = $response->toArray()['durations'][2][0];

            return $result;
        }
        throw new Exception('Le service est temporairement indisponible');
    }
}
