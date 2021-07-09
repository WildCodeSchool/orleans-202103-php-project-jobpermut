<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\Direction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermutSearchController extends AbstractController
{
    /**
     * @Route("permutsearch", name="permutsearch")
     */
    public function index(UserRepository $userRepository, Direction $direction): Response
    {
        $homeCityCoordinate = [2.8884689, 48.9562087];
        $workCityCoordinate = [2.3478, 48.8554];

        $userWorkCoordinates = [2.765796, 48.878462];

        $tripSummary1 = $direction->tripSummary($homeCityCoordinate, $workCityCoordinate);
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

        return $this->render('permutsearch/index.html.twig', [
            'users' => $userRepository->findby([], [], 5),
            'tripSummary1' => $tripSummary1,
            'tripSummary2' => $tripSummary2,
            'timeGained' => $timeGained,
        ]);
    }
}
