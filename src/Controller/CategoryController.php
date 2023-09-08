<?php

namespace App\Controller;

use App\Entity\CategoryEntity;
use App\Form\CategoryType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/categories', name: 'listCategories', methods: 'GET')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $categories = $entityManager->getRepository(CategoryEntity::class)->findAll();

        return $this->render('category/list.html.twig', [
            'categories' => $categories
        ]);
    }

    #[Route('/category/new', name: 'newCategory', methods: 'GET')]
    #[Route('/category/new', name: 'saveNewCategory', methods: 'POST')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = new CategoryEntity();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($category);
            $entityManager->flush();
            $this->redirectToRoute('listSubscriptions');
        }
        return $this->render('category/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/category/{id}', name: 'detailCategory', methods: 'GET')]
    #[Route('/category/{id}', name: 'updateCategory', methods: 'POST')]
    public function detail(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $category = $entityManager->getRepository(CategoryEntity::class)->find($id);

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            return $this->redirectToRoute('listCategories');
        }
        return $this->render('category/detail.html.twig', [
            'category' => $category,
            'form' => $form->createView()
        ]);
    }
}
