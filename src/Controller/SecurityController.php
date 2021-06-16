<?php

namespace App\Controller;

use LogicException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(SessionInterface $session, AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // get the last route for redirection if login has false
        $lastRoute = $session->get('last_route');

        $session->set('error', $error ?
        'Email ou mot de passe incorrect.' :
        'login');

        //return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
        return $this->redirectToRoute($lastRoute['route'], $lastRoute['params']);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new LogicException('This method can be blank -
        it will be intercepted by the logout key on your firewall.');
    }
}
