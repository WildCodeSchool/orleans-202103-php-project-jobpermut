<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermutSearchController extends AbstractController
{
    /**
     * @Route("permutsearch", name="permutsearch")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('permutsearch/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
}
