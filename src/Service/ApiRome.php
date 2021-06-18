<?php

namespace App\Service;

use Symfony\Component\HttpClient\Response\TraceableResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ApiRome
{
    private const URL_API = 'https://entreprise.pole-emploi.fr/';
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function testApi(): ResponseInterface
    {
        $response = $this->client->request(
            'POST',
            self::URL_API . 'connexion/oauth2/access_token?realm=%2Fpartenaire',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'query' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => ['PAR_jobpermut_517b57a3635bace4ef2769ce7905df560a153957bf3c2fe8c760d08b80062044'],
                    'client_secret' => ['29d9e80b40a3c5ef993b86c5e2237fa59b0ef48ce50cb2425b02594ecab610c2'],
                ]
            ]
        );

        return $response;
    }
}
