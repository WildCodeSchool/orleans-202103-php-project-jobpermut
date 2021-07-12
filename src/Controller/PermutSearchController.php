<?php

namespace App\Controller;

use App\Entity\Rome;
use App\Entity\User;
use App\Service\Geocode;
use App\Service\Direction;
use App\Entity\RegisteredUser;
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
        $rome = new Rome();
        $tripSummary1 = [];
        $tripSummary2 = [];
        $homeCityCoordinate = [];
        $workCityCoordinate = [];


        /** @var User */
        $user = $this->getUser();

        if ($user !== null) {
            $user = $user->getRegisteredUser();
        };

        if ($user !== null) {
            /** @var RegisteredUser */
            $rome = $user->getRome();
            $homeCityCoordinate = $geocode->getCoordinates($user->getCity());
            $workCityCoordinate = $geocode->getCoordinates($user->getCityJob());
            $tripSummary1 = $direction->tripSummary($homeCityCoordinate, $workCityCoordinate);
        };

        $userData = [
            'homeCity' => $homeCityCoordinate,
            'workCity' => $workCityCoordinate,
            'tripSummary1' => $tripSummary1,
        ];

        $usersByRome = $regUserRepo->findby(['rome' => $rome], [], 5);

        foreach ($usersByRome as $regUser) {
            if ($regUser !== $user) {
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

                if ($timeGained >= 0) {
                    $regUsersDatas[$regUser->getId()] = [
                        'registeredUser' => $regUser,
                        'userHome' => $userHomeCoordinates,
                        'userWork' => $userWorkCoordinates,
                        'tripSummary2' => $tripSummary2,
                        'timeGained' => $timeGained,
                    ];
                }
            }
        };

        usort($regUsersDatas, function ($first, $last) {
            return $last['timeGained'] <=> $first['timeGained'];
        });

        return $this->render('permutsearch/index.html.twig', [
            'userData' => $userData,
            'regUsersData' => $regUsersDatas
        ]);
    }
}
