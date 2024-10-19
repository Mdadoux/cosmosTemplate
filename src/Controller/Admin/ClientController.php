<?php

namespace App\Controller\Admin;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

#[Route('/admin/clients')]
class ClientController extends AbstractController
{
    #[Route('/', name: 'clients')]
    public function index(Request $request, ClientRepository $repository): Response
    {
        $clients = $repository->findAll();

        return $this->render('admin/client/client-index.html.twig', [
            'listClients' => $clients,
        ]);
    }

    #[Route('/{id}', name: 'client.show', requirements: ['id' => '\d+'])]
    public function show(Request $request, int $id, ClientRepository $repository): Response
    {
        $client = $repository->find($id);

        return $this->render('admin/client/client-show.html.twig');
    }

    #[Route('/create', 'client.create')]
    public function create(Request $resquest, EntityManagerInterface $em)
    {
        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($resquest);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($client);
            $em->flush();
            $this->addFlash('success', 'Un nouveau client vien d\'être ajouté');

            return $this->redirectToRoute('clients');
        }

        return $this->render('admin/client/client-create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edite', 'client.edite', methods: ['GET','POST'],requirements: ['id'=>Requirement::DIGITS])]
    public function edit(Client $client, Request $resquest, EntityManagerInterface $em)
    {
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($resquest);
        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Les infos client ont bien été mis à jours !');

            return $this->redirectToRoute('clients');
        }

        return $this->render('admin/client/client-edite.html.twig', [
            'client' => $client,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', 'client.delete', methods: ['DELETE'], requirements: ['id' => Requirement::DIGITS])]
    public function delete(Client $client, Request $resquest, EntityManagerInterface $em)
    {
        $em->remove($client);
        $em->flush();
        $this->addFlash('success', 'Les infos client ont bien été Supprimés !');
        return $this->redirectToRoute('clients');
    }
}
