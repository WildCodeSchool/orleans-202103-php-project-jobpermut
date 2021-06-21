<?php

namespace App\Service\ApiRome;

use App\Service\ApiRome\ApiRomeJobs;

class ApiRomeAppellations extends ApiRomeJobs
{
    /**
     * return all appelation for one job
     *
     * @param array $job
     * @return array
     */
    public function getAppelationsByJob(array $job): array
    {
        $response = $this->client->request(
            'GET',
            self::URL_REQUEST_GET . 'metier/' . $job['code'] . '/appellation',
            [
                'headers' =>  [
                    'Authorization' => $this->getToken()
                ],
            ]
        );

        return $response->toArray();
    }

    public function getAllAppelations(): array
    {
        $response = $this->client->request(
            'GET',
            self::URL_REQUEST_GET . 'appellation',
            [
                'headers' =>  [
                    'Authorization' => $this->getToken()
                ],
            ]
        );

        return $response->toArray();
    }
}
