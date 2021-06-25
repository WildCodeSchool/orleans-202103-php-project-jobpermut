<?php

namespace App\Controller;

use RuntimeException;
use LogicException;
use App\Service\Geocode;
use App\Entity\VisitorTrip;
use App\Form\VisitorTripType;
use App\Service\Matrix;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home", methods={"POST", "GET"})
     */
    public function index(Request $request, Geocode $geocode, SessionInterface $session, Matrix $matrix): Response
    {
        $visitorTrip = new VisitorTrip();
        $form = $this->createForm(VisitorTripType::class, $visitorTrip);
        $form->handleRequest($request);

        $homeCityCoordinate = [0, 0];
        $workCityCoordinate = [0, 0];

        if ($form->isSubmitted() && $form->isValid()) {
            $homeCity = $visitorTrip->getHomeCity();
            $workCity = $visitorTrip->getWorkCity();
            try {
                $homeCityCoordinate = $geocode->getCoordinates($homeCity);
                $workCityCoordinate = $geocode->getCoordinates($workCity);
                return $this->redirectToRoute('home', [
                    '_fragment' => 'map',
                    'homeLong' => $homeCityCoordinate[0] ?? 0,
                    'homeLat' => $homeCityCoordinate[1] ?? 0,
                    'workLong' => $workCityCoordinate[0] ?? 0,
                    'workLat' => $workCityCoordinate[1] ?? 0,
                ]);
            } catch (LogicException $e) {
                $exception = $e->getMessage();
                $this->addFlash('geocode', $exception);
            } catch (RuntimeException $e) {
                $exception = $e->getMessage();
                $this->addFlash('geocode', $exception);
            }

            return $this->redirectToRoute('home', [
                '_fragment' => 'map',
            ]);
        }
        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
