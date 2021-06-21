<?php

namespace App\Controller;

use App\Form\RomeType;
use App\Service\ApiRome\ApiRome;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ApiRome $apiRome): Response
    {
        $form = $this->createForm(RomeType::class);

        return $this->render('home/test.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
