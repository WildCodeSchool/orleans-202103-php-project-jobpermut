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
        string $homeStart,
        string $homeEnd,
        string $workStart,
        string $workEnd,
        Direction $direction
    ): Response {
        $home = $homeStart . "," . $homeEnd;
        $work = $workStart . "," . $workEnd;

        return $this->json($direction->getDirection($home, $work));
    }
}
