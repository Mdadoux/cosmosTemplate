<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/projects')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'projects', methods: ['GET'])]
    public function index(ProjectRepository $projectRepository): Response
    {
        return $this->render('admin/project/project-index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/create', name: 'project.create', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $project = new Project();
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($project);
            $entityManager->flush();
            $this->addFlash('success', 'Projet ajouté !');
            return $this->redirectToRoute('projects', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/project/project-create.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'project.show', methods: ['GET'])]
    public function show(Project $project): Response
    {
        return $this->render('admin/project/project-show.html.twig', [
            'project' => $project,
        ]);
    }

    #[Route('/{id}/edit', name: 'project.edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Les infos du projet ont bien été mis à jours !');
            return $this->redirectToRoute('projects', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/project/project-edit.html.twig', [
            'project' => $project,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'project.delete', methods: ['POST'])]
    public function delete(Request $request, Project $project, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$project->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($project);
            $entityManager->flush();
            $this->addFlash('success', 'Projet Supprimé !');
        }

        return $this->redirectToRoute('projects', [], Response::HTTP_SEE_OTHER);
    }
}
