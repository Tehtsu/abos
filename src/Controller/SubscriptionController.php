<?php

namespace App\Controller;

use App\Form\SubscriptionType;
use DateTime;
use App\Entity\SubscriptionEntity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/app')]
class SubscriptionController extends AbstractController
{
    #[Route('/subscriptions', name: 'listSubscriptions', methods: ["GET"])]
    public function read(EntityManagerInterface $entityManager): Response
    {
        $subscriptions = $entityManager
            ->getRepository(SubscriptionEntity::class)
            ->findBy(['user' => $this->getUser()]);

        return $this->render('subscription/list.html.twig', [
            'subscriptions' => $subscriptions
        ]);
    }

    #[Route('/subscription/new', name: 'newSubscription', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $subscription = new SubscriptionEntity();
        $subscription->setStartDate(new DateTime());

        $form = $this->createForm(SubscriptionType::class, $subscription);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($subscription);
            $entityManager->flush();
            return $this->redirectToRoute('listSubscriptions');
        }
        return $this->render('subscription/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/subscription/{id}', name: 'detailSubscription', methods: 'GET')]
    #[Route('/subscription/{id}', name: 'updateSubscription', methods: 'POST')]
    public function detail(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $subscription = $entityManager->getRepository(SubscriptionEntity::class)->find($id);
        $this->denyAccessUnlessGranted('MANAGE',$subscription);

        $form = $this->createForm(SubscriptionType::class, $subscription);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            return $this->redirectToRoute('listSubscriptions');
        }
        return $this->render('subscription/detail.html.twig', [
            'subscription' => $subscription,
            'form' => $form->createView()
        ]);

    }
}
