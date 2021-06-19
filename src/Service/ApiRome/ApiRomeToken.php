<?php

namespace App\Service\ApiRome;

use App\Service\ApiRome\ApiRomeConfig;

class ApiRomeToken extends ApiRomeConfig
{
    /**
     * Get Authorization Token for all request Pole Emploi
     *
     * @return string
     */
    protected function getToken(): string
    {
        $response = $this->getClient()->request(
            'POST',
            self::URL_TOKEN . 'connexion/oauth2/access_token?realm=%2Fpartenaire',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'query' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->getClientId(),
                    'client_secret' => $this->getSecretKey(),
                    'scope' => 'application_' . $this->getClientId() . ' api_romev1 nomenclatureRome'
                ]
            ]
        );

        return $response->toArray()['access_token'];
    }
}
