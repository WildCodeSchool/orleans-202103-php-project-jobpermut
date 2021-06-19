<?php

namespace App\Controller;

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
        dd($apiRome->getOgr(11158));

        return $this->render('home/index.html.twig');
    }
}
