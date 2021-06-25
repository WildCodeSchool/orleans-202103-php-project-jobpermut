<?php

namespace App\Controller;

use App\Entity\VisitorTrip;
use App\Form\VisitorTripType;
use App\Service\Geocode;
use App\Service\Matrix;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, Geocode $geocode, Matrix $matrix): Response
    {
        $visitorTrip = new VisitorTrip();
        $form = $this->createForm(VisitorTripType::class, $visitorTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $homeCity = $visitorTrip->getHomeCity();
            $workCity = $visitorTrip->getWorkCity();
            $homeCityCoordinate = $geocode->getCoordinates($homeCity);
            $workCityCoordinate = $geocode->getCoordinates($workCity);

            $visitorTrip->setHomeCityCoordinates($homeCityCoordinate);
            $visitorTrip->setWorkCityCoordinates($workCityCoordinate);
            return $this->redirectToRoute('home');
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
