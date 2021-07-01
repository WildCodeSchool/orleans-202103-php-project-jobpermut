<?php

namespace App\Controller;

use App\Service\Direction;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/leaflet", name="leaflet_")
 */
class LeafletController extends AbstractController
{
    /**
    * @Route("/direction/{homeStart}/{homeEnd}/{workStart}/{workEnd}", name="direction")
    */
    public function direction(
        float $homeStart,
        float $homeEnd,
        float $workStart,
        float $workEnd,
        Direction $direction
    ): Response {
        $homeCoordinate[] = $homeStart;
        $homeCoordinate[] = $homeEnd;
        $workCoordinate[] = $workStart;
        $workCoordinate[] = $workEnd;

        return $this->json($direction->getDirection($homeCoordinate, $workCoordinate));
    }
}
