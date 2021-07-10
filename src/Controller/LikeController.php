<?php

namespace App\Controller;

use App\Entity\UserLike;
use App\Entity\User;
use App\Repository\UserLikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LikeController extends AbstractController
{
    /**
     * @Route("/{user}/like", name="like")
     */
    public function addLike(
        User $user,
        UserLikeRepository $userLikeRepository,
        EntityManagerInterface $entityManager
    ): Response {
        $heart = false;

        /** @var User */
        $userLiker = $this->getUser();

        $userLike = $userLikeRepository->findOneBy([
            'userLiker' => $userLiker,
            'userLiked' => $user
        ]);

        if ($userLike == null) {
            $userLike = new UserLike();
            $userLike->setUserLiker($userLiker);
            $userLike->setUserLiked($user);
            $entityManager->persist($userLike);
            $heart = true;
        } else {
            $userLiker->removeUserLike($userLike);
            $entityManager->remove($userLike);
        }

        $entityManager->flush();

        return $this->json([
            'heart' => $heart
        ]);
    }
}
