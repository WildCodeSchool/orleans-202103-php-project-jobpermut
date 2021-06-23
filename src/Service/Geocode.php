<?php

namespace App\Service;

use Exception;
use Symfony\Component\HttpClient\HttpClient;

class Geocode
{
    private string $key;
    private const STATUS = 200;

    public function __construct(string $key)
    {
        $this->key = $key;
    }

    public function getCoordinates(?string $location, string $layer = 'locality', string $country = 'FRA'): ?array
    {
        $content = [];
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://api.openrouteservice.org/geocode/autocomplete',
            [
                'query' => [
                    'api_key' => $this->key,
                    'layer' => $layer,
                    'boundary.country' => $country,
                    'text' => $location
                ]
            ]
        );
        $statusCode = $response->getStatusCode(); // get Response status code 200

        if ($statusCode === Geocode::STATUS) {
            $content = $response->getContent();
            // get the response in JSON format

            $content = $response->toArray();
            // convert the response (here in JSON) to an PHP array
            return $content['features'][0]['geometry']['coordinates'];
        }

        throw new Exception('Le service est temporairement indisponible');
    }
}
