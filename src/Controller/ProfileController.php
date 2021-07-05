<?php

namespace App\Controller;

use App\Entity\RegisteredUser;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RegisteredUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/profil", name="profile_")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{username}", name="show")
     * @ParamConverter("user", class="App\Entity\User"),
     * options={"mapping": {"username": "username"}})
     */
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{username}/edit", name="edit", methods={"GET","POST"})
     * @ParamConverter("user", class="App\Entity\User"),
     * options={"mapping": {"username": "username"}})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        if ($user !== $this->getUser()) {
            return new RedirectResponse('/error403');
        }

        $registeredUser = new RegisteredUser();
        $registeredUser->setUser($user);

        $form = $this->createForm(RegisteredUserType::class, $user->getRegisteredUser() ?? $registeredUser);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$user->getRegisteredUser()) {
                $entityManager->persist($registeredUser);
            }

            $entityManager->flush();

            $this->addFlash('success', 'Votre profil a bien été modifié.');

            return $this->redirectToRoute('profile_show', ['username' => $user->getUsername()]);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
