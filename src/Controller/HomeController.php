<?php

namespace App\Controller;

use RuntimeException;
use LogicException;
use App\Service\Geocode;
use App\Entity\VisitorTrip;
use App\Form\VisitorTripType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, Geocode $geocode): Response
    {
        $visitorTrip = new VisitorTrip();
        $form = $this->createForm(VisitorTripType::class, $visitorTrip);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $homeCityCoordinate = [];
                $workCityCoordinate = [];

                $homeCity = $visitorTrip->getHomeCity();
                $workCity = $visitorTrip->getWorkCity();
                try {
                    $homeCityCoordinate = $geocode->getCoordinates($homeCity);
                    $workCityCoordinate = $geocode->getCoordinates($workCity);
                } catch (LogicException $e) {
                    $exception = [
                       'class' => 'warning',
                       'text' => $e->getMessage(),
                    ];
                    $this->addFlash('geocode', $exception);
                } catch (RuntimeException $e) {
                    $exception = [
                        'class' => 'danger',
                        'text' => $e->getMessage(),
                    ];
                    $this->addFlash('geocode', $exception);
                }
                $visitorTrip->setHomeCityCoordinates($homeCityCoordinate);
                $visitorTrip->setworkCityCoordinates($workCityCoordinate);
            }
            return $this->redirectToRoute('home', ['_fragment' => 'map']);
        }

        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
