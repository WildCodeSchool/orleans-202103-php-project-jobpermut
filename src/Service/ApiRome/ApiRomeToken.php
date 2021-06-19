<?php

namespace App\Service\ApiRome;

use App\Service\ApiRome\ApiRomeConstants;

class ApiRomeToken extends ApiRomeConstants
{
    /**
     * Get Authorization Token for all request Pole Emploi
     *
     * @return string
     */
    protected function getToken(): string
    {
        $response = $this->client->request(
            'POST',
            self::URL_TOKEN . 'connexion/oauth2/access_token?realm=%2Fpartenaire',
            [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'query' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => 'PAR_jobpermut_ceb5390408c34f309502ff23c3cf574703fe1771b153bba6610914bca60c46b1',
                    'client_secret' => '6ed3f777a559c7e75b0c0bd2fd4a3cf23dd686940210a0907a0b3a573bd92fa0',
                    'scope' => 'application_PAR_jobpermut_ceb5390408c34f309502ff23c3cf574703fe1771b153bba6610914bca60c46b1 api_romev1 nomenclatureRome'
                ]
            ]
        );

        return $response->toArray()['access_token'];
    }
}
