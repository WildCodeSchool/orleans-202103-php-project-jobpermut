<?php

namespace App\Controller;

use App\Entity\RegisteredUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * @Route("/profile", name="profile_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{username}", name="show")
     * @ParamConverter("registeredUser", class="App\Entity\RegisteredUser",
     * options={"mapping": {"username": "username"}})
     */
    public function show(RegisteredUser $registeredUser): Response
    {
        return $this->render('profile/show.html.twig', [
            'registeredUser' => $registeredUser,
        ]);
    }
}
