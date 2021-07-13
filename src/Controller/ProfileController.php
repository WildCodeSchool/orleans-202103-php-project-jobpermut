<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\Geocode;
use App\Service\Direction;
use App\Entity\RegisteredUser;
use App\Form\RegisteredUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
    public function show(User $user, Geocode $geocode, Direction $direction): Response
    {
        $homeCityCoordinate = [];
        $workCityCoordinate = [];

        /** @var RegisteredUser */
        $regUser = $user->getRegisteredUser();

        if ($user !== null) {
            $homeCityCoordinate = $geocode->getCoordinates($regUser->getCity());
            $workCityCoordinate = $geocode->getCoordinates($regUser->getCityJob());


        };

        $userData = [
            'homeCity' => $homeCityCoordinate,
            'workCity' => $workCityCoordinate
        ];

        return $this->render('profile/show.html.twig', [
            'user' => $user,
            'userData' => $userData,
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

            if ($request->get('premium')) {
                return $this->redirectToRoute('subscription_new');
            }

            return $this->redirectToRoute('profile_show', ['username' => $user->getUsername()]);
        }

        dd($user);

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
