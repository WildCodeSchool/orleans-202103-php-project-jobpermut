<?php

namespace App\Service\ApiRome;

use App\Service\ApiRome\ApiRomeToken;

class ApiRomeJobs extends ApiRomeToken
{
    /**
     * Return list of all jobs
     *
     * @return array
     */
    public function getJobs(): array
    {
        $response = $this->client->request(
            'GET',
            self::URL_REQUEST_GET . 'metier',
            [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->getToken()
                ]
            ]
        );

        return $response->toArray();
    }
}
