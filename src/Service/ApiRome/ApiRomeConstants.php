<?php

namespace App\Service\ApiRome;

use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class ApiRomeConstants
{
    protected const URL_TOKEN = 'https://entreprise.pole-emploi.fr/';
    protected const URL_REQUEST_GET = 'https://api.emploi-store.fr/partenaire/rome/v1/';

    protected HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
}
