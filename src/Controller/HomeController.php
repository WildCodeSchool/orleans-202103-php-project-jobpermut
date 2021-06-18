<?php

namespace App\Controller;

use App\Service\ApiRome;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ApiRome $apiRome): Response
    {
        dd($apiRome->testApi());
        return $this->render('home/index.html.twig');
    }
}
