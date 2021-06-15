<?php

namespace App\Service;

use OndraM\CiDetector\Env;
use Symfony\Component\HttpClient\HttpClient;

class Geocode
{
    public function request(string $city): array
    {
        $content = [];
        $client = HttpClient::create();
        $response = $client->request(
            'GET',
            '%env{OPENROUTESERVICE_KEY}%' . $city
        );

        $content = $response->toArray();
        // convert the response (here in JSON) to an PHP array


        return $content;
    }
}
