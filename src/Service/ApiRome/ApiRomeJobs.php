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
    public function getAllJobs(): array
    {
        $response = $this->client->request(
            'GET',
            self::URL_REQUEST_GET . 'metier',
            [
                'headers' =>  [
                    'Authorization' => $this->getToken()
                ],
            ]
        );

        return $response->toArray();
    }

    /**
     * Return list of jobs by query in ajax
     *
     * @return array
     */
    public function getJobsByName(string $query): array
    {
        $response = $this->client->request(
            'GET',
            self::URL_REQUEST_GET . 'metier',
            [
                'headers' =>  [
                    'Authorization' => $this->getToken()
                ],
                'query' => [
                    'q' => $query
                ]
            ]
        );

        return $response->toArray();
    }
}
