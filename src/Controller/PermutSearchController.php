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
        $tripSummary1 = [];
        $homeCityCoordinate = [];
        $workCityCoordinate = [];
        $rome = new Rome();


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

        $this->dataRecup(
            $usersByRome,
            $user,
            $homeCityCoordinate,
            $workCityCoordinate,
            $tripSummary1,
            $geocode,
            $direction
        );

        usort($regUsersDatas, function ($first, $last) {
            return $last['timeGained'] <=> $first['timeGained'];
        });

        return $this->render('permutsearch/index.html.twig', [
            'userData' => $userData,
            'regUsersData' => $regUsersDatas
        ]);
    }

    private function dataRecup(
        ?array $usersByRome,
        ?RegisteredUser $user,
        ?array $homeCityCoordinate,
        ?array $workCityCoordinate,
        ?array $tripSummary1,
        Geocode $geocode,
        Direction $direction
    ): array {
        $regUsersDatas = [];
        foreach ($usersByRome as $regUser) {
            if ($regUser !== $user) {
                $userHomeCoordinates = $geocode->getCoordinates($regUser->getCity());
                $userWorkCoordinates = $geocode->getCoordinates($regUser->getCityJob());
                $tripSummary2 = $direction->tripSummary($homeCityCoordinate, $userWorkCoordinates);
                $tripSummary3 = $direction->tripSummary($userHomeCoordinates, $workCityCoordinate);
                $tripSummary4 = $direction->tripSummary($userHomeCoordinates, $userWorkCoordinates);

                $duration1 = 0;
                $duration2 = 0;
                $duration3 = 0;
                $duration4 = 0;

                if ($tripSummary1 && $tripSummary2 && $tripSummary3 && $tripSummary4) {
                    $duration1 = (intval($tripSummary1['duration']['hours']) * 60) +
                        (intval($tripSummary1['duration']['minutes']));

                    $duration2 = (intval($tripSummary2['duration']['hours']) * 60) +
                        (intval($tripSummary2['duration']['minutes']));


                    $duration3 = (intval($tripSummary3['duration']['hours']) * 60) +
                        (intval($tripSummary3['duration']['minutes']));

                    $duration4 = (intval($tripSummary4['duration']['hours']) * 60) +
                        (intval($tripSummary4['duration']['minutes']));
                }

                $timeGained = $duration1 - $duration2;
                $otherTimeGained = $duration4 - $duration3;

                if ($timeGained >= 0 && $otherTimeGained >= 0) {
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
        return $regUsersDatas;
    }
}
