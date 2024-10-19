<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/categories')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'categories')]
    public function index(CategoryRepository $repository): Response
    {
        return $this->render('admin/category/category-index.html.twig', [
            'categories' => $repository->findAll(),
        ]);
    }

    #[Route('/create', name: 'category.create')]
    public function create(Request $request, EntityManagerInterface $entityManager)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'La catégory a bien été créee !');

            return $this->redirectToRoute('categories');
        }

        return $this->render('admin/category/category-create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edite', name: 'category.edite', requirements: ['id' => Requirement::DIGITS], methods: ['GET', 'POST'])]
    public function edite(Category $category, Request $request, EntityManagerInterface $entityManager)
    {
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'La catégory a bien été créee !');

            return $this->redirectToRoute('categories');
        }

        return $this->render('admin/category/category-edite.html.twig', [
            'form' => $form,
            'category' => $category,
        ]);
    }

    #[Route('/{id}/delete', name: 'category.delete', requirements: ['id' => Requirement::DIGITS], methods: ['DELETE'])]
    public function delete(Category $category, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($category);
        $entityManager->flush();
        $this->addFlash('success', 'La catégory a bien été supprimée !');
        return $this->redirectToRoute('categories');
    }
}
