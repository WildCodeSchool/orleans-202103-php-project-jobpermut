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
        $homeCityCoordinate = [2.8884657, 48.9562018];
        $workCityCoordinate = [2.3488, 48.8534];

        $tripSummary1 = [];
        $tripSummary2 = [];

        $userWorkCoordinates = [2.765796, 48.878462];

        $tripSummary1 = $direction->tripSummary($homeCityCoordinate, $workCityCoordinate);
        $tripSummary2 = $direction->tripSummary($homeCityCoordinate, $userWorkCoordinates);

        return $this->render('permutsearch/index.html.twig', [
            'users' => $userRepository->findby([], [], 5),
            'tripSummary1' => $tripSummary1,
            'tripSummary2' => $tripSummary2
        ]);
    }
}
