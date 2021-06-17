<?php

namespace App\Controller;

use App\Entity\RegisteredUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegisteredUserType;

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

    /**
     * @Route("/{username}/edit", name="edit", methods={"GET","POST"})
     * @ParamConverter("registeredUser", class="App\Entity\RegisteredUser",
     * options={"mapping": {"username": "username"}})
     */
    public function edit(Request $request, RegisteredUser $registeredUser): Response
    {
        $form = $this->createForm(RegisteredUserType::class, $registeredUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('profile_show', ['username' => $registeredUser->getUsername()]);
        }

        return $this->render('profile/edit.html.twig', [
            'registeredUser' => $registeredUser,
            'form' => $form->createView(),
        ]);
    }
}
