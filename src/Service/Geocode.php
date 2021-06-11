<?php

namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;

class Geocode
{
    public function request(string $city): array
    {
        $content = [];
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            'https://api.openrouteservice.org/geocode/autocomplete?
            api_key=5b3ce3597851110001cf6248ecf8b45b3e3f4969a29278100e6e0664&text=' . $city
        );

        $content = $response->toArray();
        // convert the response (here in JSON) to an PHP array


        return $content;
    }
}
