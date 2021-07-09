<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Subscription;
use App\Entity\RegisteredUser;
use App\Form\SubscriptionType;
use App\Repository\CompanyRepository;
use App\Repository\RegisteredUserRepository;
use App\Service\ApiRome\ApiRome;
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
     * @Route("/new", name="new")
     */
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        CompanyRepository $companyRepository,
        ApiRome $apiRome
    ): Response {
        /** @var User */
        $user = $this->getUser();

        /** @var RegisteredUser */
        $registeredUser = $user->getRegisteredUser();
        $subscription = $registeredUser->getSubscription();

        if ($subscription) {
            return $this->redirectToRoute(
                'subscription_edit',
                ['subscription' => $subscription->getId()]
            );
        } else {
            $subscription = new Subscription();
        }

        $rome = $registeredUser != null ? $registeredUser->getRome() : null;
        $form = $this->createForm(SubscriptionType::class, $subscription, ['rome' => $rome]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($subscription->getCompagnyCode()) {
                $subscription->setCompany($companyRepository->findOneBy(['code' => $subscription->getCompagnyCode()]));
            }

            $ogr = strval($subscription->getOgrCode());

            if ($ogr !== $subscription->getOgrCode()) {
                $ogrName = $apiRome->getDetailsOfAppellation($ogr)['libelleCourt'];
                $subscription->setOgrName($ogrName);
            }

            $subscription->setSubscriptionAt(new DateTimeImmutable());
            $entityManager->persist($subscription);
            $entityManager->flush();

            $registeredUser->setSubscription($subscription);
            $entityManager->flush();
            return $this->redirectToRoute('profile_show', ['username' => $user->getUsername()]);
        }

        return $this->render('subscription/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{subscription}/edit", name="edit")
     */
    public function edit(
        Subscription $subscription,
        RegisteredUserRepository $registeredRepository,
        Request $request,
        EntityManagerInterface $entityManager,
        CompanyRepository $companyRepository,
        ApiRome $apiRome
    ): Response {

        /** @var User */
        $user = $this->getUser();

        /** @var RegisteredUser */
        $registeredUser = $registeredRepository->findOneBy([
            'subscription' => $subscription
        ]);

        $rome = $registeredUser->getRome();

        $form = $this->createForm(SubscriptionType::class, $subscription, ['rome' => $rome]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($subscription->getCompagnyCode()) {
                $subscription->setCompany($companyRepository->findOneBy(['code' => $subscription->getCompagnyCode()]));
            }

            $ogr = strval($subscription->getOgrCode());

            if ($ogr !== $subscription->getOgrCode()) {
                $ogrName = $apiRome->getDetailsOfAppellation($ogr)['libelleCourt'];
                $subscription->setOgrName($ogrName);
            }

            $subscription->setUpdatedAt(new DateTimeImmutable());
            $entityManager->persist($subscription);
            $entityManager->flush();

            return $this->redirectToRoute('profile_show', ['username' => $user->getUsername()]);
        }

        return $this->render('subscription/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}