<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Geocode;
use App\Service\Direction;
use App\Repository\RegisteredUserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PermutSearchController extends AbstractController
{
    /**
     * @Route("permutsearch", name="permutsearch")
     */
    public function index(RegisteredUserRepository $regUserRepo, Direction $direction, Geocode $geocode): Response
    {
        $regUsersDatas = [];

        /** @var User */
        $user = $this->getUser();
        $user = $user->getRegisteredUser();

        if ($user != null) {
            $rome = $user->getRome();
            $userId = $user->getId();
        }

        $homeCityCoordinate = $geocode->getCoordinates($user->getCity());
        $workCityCoordinate = $geocode->getCoordinates($user->getCityJob());
        $tripSummary1 = $direction->tripSummary($homeCityCoordinate, $workCityCoordinate);

        $userData = [ $userId => [
            'homeCity' => $homeCityCoordinate,
            'workCity' => $workCityCoordinate,
            'tripSummary1' => $tripSummary1,
            ]
        ];

        $usersRome = $regUserRepo->findby(['rome' => $rome], [], 5);

        foreach ($usersRome as $regUser) {
            $userHomeCoordinates = $geocode->getCoordinates($regUser->getCity());
            $userWorkCoordinates = $geocode->getCoordinates($regUser->getCityJob());
            $tripSummary2 = $direction->tripSummary($homeCityCoordinate, $userWorkCoordinates);

            $duration1 = 0;
            $duration2 = 0;

            if ($tripSummary1) {
                $duration1 = (intval($tripSummary1['duration']['hours']) * 60) +
                    (intval($tripSummary1['duration']['minutes']));
            }

            if ($tripSummary2) {
                $duration2 = (intval($tripSummary2['duration']['hours']) * 60) +
                    (intval($tripSummary2['duration']['minutes']));
            }

            $timeGained = $duration1 - $duration2;

            $regUsersDatas[$regUser->getId()] = [
                'userHome' => $userHomeCoordinates,
                'userWork' => $userWorkCoordinates,
                'tripSummary2' => $tripSummary2,
                'timeGained' => $timeGained,
            ];

            unset($regUsersDatas[$userId]);

        };

        dd($regUsersDatas);


        return $this->render('permutsearch/index.html.twig', [
            'users' => $regUserRepo->findby(['rome' => $rome], [], 5),
            'userData' => $userData,
            'regUsersData' => $regUsersDatas
        ]);
    }
}
