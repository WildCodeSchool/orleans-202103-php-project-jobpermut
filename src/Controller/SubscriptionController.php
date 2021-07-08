<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\RegisteredUser;
use App\Form\SubscriptionType;
use App\Repository\CompanyRepository;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/subscription", name="subscription_")
 */
class SubscriptionController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(
        Request $request,
        EntityManagerInterface $entityManager,
        CompanyRepository $companyRepository
    ): Response {
        $subscription = new Subscription();
        /** @var User */
        $user = $this->getUser();
        /** @var RegisteredUser */
        $registeredUser = $user->getRegisteredUser();
        $rome = $registeredUser != null ? $registeredUser->getRome() : null;
        $form = $this->createForm(SubscriptionType::class, $subscription, ['rome' => $rome]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($subscription->getCompagnyCode()) {
                $subscription->setCompany($companyRepository->findOneBy(['code' => $subscription->getCompagnyCode()]));
            }

            $subscription->setSubscriptionAt(new DateTimeImmutable());

            $entityManager->persist($subscription);
            $entityManager->flush();
        }

        return $this->render('subscription/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
