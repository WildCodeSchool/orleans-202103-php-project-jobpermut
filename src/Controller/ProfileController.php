<?php

namespace App\Controller;

use App\Entity\Rome;
use App\Entity\User;
use App\Service\Geocode;
use App\Service\Direction;
use App\Entity\RegisteredUser;
use App\Form\RegisteredUserType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;
use App\Repository\RegisteredUserRepository;
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

            if ($request->get('premium')) {
                return $this->redirectToRoute('subscription_new');
            }

            return $this->redirectToRoute('profile_show', ['username' => $user->getUsername()]);
        }

        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{username}/like", name="showLike")
     */
    public function showLike(RegisteredUserRepository $regUserRepo, Direction $direction, Geocode $geocode): Response
    {
        $regUsersDatas = [];
        $regUsersDatas2 = [];
        $rome = new Rome();
        $user = new User();
        $tripSummary1 = [];
        $tripSummary2 = [];
        $homeCityCoordinate = [];
        $workCityCoordinate = [];


        /** @var User */
        $user = $this->getUser();

        if ($user !== null) {
            $regUser = $user->getRegisteredUser();
        };

        if ($regUser !== null) {
            /** @var RegisteredUser */
            $rome = $regUser;
            $homeCityCoordinate = $geocode->getCoordinates($regUser->getCity());
            $workCityCoordinate = $geocode->getCoordinates($regUser->getCityJob());
            $tripSummary1 = $direction->tripSummary($homeCityCoordinate, $workCityCoordinate);
        };

        $userData = [
            'homeCity' => $homeCityCoordinate,
            'workCity' => $workCityCoordinate,
            'tripSummary1' => $tripSummary1,
        ];

        if ($user !== null) {
            $userLikes = $user->getUserLikes();
        }


        if ($user !== null) {
            $userLiked = $user->getUserLikedBy();
        };

        $regUsersDatas = $this->getLikedUsers($userLikes, $regUserRepo, $direction, $geocode, $homeCityCoordinate, $tripSummary1, $tripSummary2);

        foreach ($userLiked as $regUser) {
            /** @var User */
            $likedUser = $regUser->getUserLiker();
            /** @var RegisteredUser */
            $regUser = $likedUser->getRegisteredUser();
            if ($regUser !== $user) {
                $userHomeCoordinates = $geocode->getCoordinates($regUser->getCity());
                $userWorkCoordinates = $geocode->getCoordinates($regUser->getCityJob());
                $tripSummary2 = $direction->tripSummary($homeCityCoordinate, $userWorkCoordinates);

                $duration1 = 0;
                $duration2 = 0;

                if ($tripSummary1) {
                    $duration1 = (intval($tripSummary1['duration']['hours']) * 60) +
                        (intval($tripSummary1['duration']['minutes']));
                }

                if ($tripSummary2) {
                    $duration2 = (intval($tripSummary2['duration']['hours']) * 60) +
                        (intval($tripSummary2['duration']['minutes']));
                }

                $timeGained = $duration1 - $duration2;

                if ($timeGained >= 0) {
                    $regUsersDatas2[$regUser->getId()] = [
                        'registeredUser' => $regUser,
                        'userHome' => $userHomeCoordinates,
                        'userWork' => $userWorkCoordinates,
                        'tripSummary2' => $tripSummary2,
                        'timeGained' => $timeGained,
                    ];
                }
            }
        };

        usort($regUsersDatas2, function ($first, $last) {
            return $last['timeGained'] <=> $first['timeGained'];
        });

        return $this->render('profile/showLike.html.twig', [
            'userData' => $userData,
            'regUsersData' => $regUsersDatas,
            'regUsersData2' => $regUsersDatas2
        ]);
    }
    public function getLikedUsers(Collection $userLikes, RegisteredUserRepository $regUserRepo, Direction $direction, Geocode $geocode, $homeCityCoordinate, $tripSummary1, $tripSummary2)
    {
        $user = $this->getUser();
        foreach ($userLikes as $regUser) {
            /** @var User */
            $likedUser = $regUser->getUserLiked();
            /** @var RegisteredUser */
            $regUser = $likedUser->getRegisteredUser();
            if ($regUser !== $user) {
                $userHomeCoordinates = $geocode->getCoordinates($regUser->getCity());

                $userWorkCoordinates = $geocode->getCoordinates($regUser->getCityJob());
                $tripSummary2 = $direction->tripSummary($homeCityCoordinate, $userWorkCoordinates);

                $duration1 = 0;
                $duration2 = 0;

                if ($tripSummary1) {
                    $duration1 = (intval($tripSummary1['duration']['hours']) * 60) +
                        (intval($tripSummary1['duration']['minutes']));
                }

                if ($tripSummary2) {
                    $duration2 = (intval($tripSummary2['duration']['hours']) * 60) +
                        (intval($tripSummary2['duration']['minutes']));
                }

                $timeGained = $duration1 - $duration2;

                if ($timeGained >= 0) {
                    $regUsersDatas[$regUser->getId()] = [
                        'registeredUser' => $regUser,
                        'userHome' => $userHomeCoordinates,
                        'userWork' => $userWorkCoordinates,
                        'tripSummary2' => $tripSummary2,
                        'timeGained' => $timeGained,
                    ];
                }
            }
        };

        usort($regUsersDatas, function ($first, $last) {
            return $last['timeGained'] <=> $first['timeGained'];
        });
        return $regUsersDatas;
    }
}
