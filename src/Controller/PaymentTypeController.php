<?php

namespace App\Controller;

use App\Entity\PaymentTypeEntity;
use App\Form\PaymentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PaymentTypeController extends AbstractController
{
    #[Route('/paymentTypes', name: 'listPaymentTypes', methods: 'GET')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $paymentTypes = $entityManager->getRepository(PaymentTypeEntity::class)->findAll();


        return $this->json([
            'paymentTypes' => $paymentTypes
        ]);
    }

    #[Route('/paymentType/new', name: 'newPaymentType', methods: 'GET')]
    #[Route('/paymentType/new', name: 'saveNewPaymentType', methods: 'POST')]
    public function new(Request $request, EntityManagerInterface $entityManager):Response
    {
        $paymentType = new PaymentTypeEntity();

        $form = $this->createForm(PaymentType::class, $paymentType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($paymentType);
            $entityManager->flush();
            return $this->redirectToRoute('listSubscriptions');
        }
        return $this->render('paymentType/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
