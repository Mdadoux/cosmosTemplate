<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Client;
use App\Entity\Project;
use App\Entity\Technology;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractDashboardController
{
    public function __construct(private AdminUrlGenerator $adminUrlGenerator)
    {
    }

    // #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        // return $this->redirect($adminUrlGenerator->setController(ClientCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        return $this->render('admin/dashboard-index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Djs Studio');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::subMenu('Gestion Client', 'fas fa-users')->setSubItems([
            MenuItem::linkToCrud('Liste clients', 'fas fa-user-alt', Client::class)->setAction(Crud::PAGE_INDEX),
            MenuItem::linkToCrud('Ajouter client', 'fas fa-user-plus', Client::class)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::subMenu('Portfolio', 'fas fa-archive')->setSubItems([
              MenuItem::linkToCrud('Catégories', 'far fa-folder', Category::class)->setAction(Crud::PAGE_INDEX),
              MenuItem::linkToCrud('Projets', 'fas fa-project-diagram', Project::class)->setAction(Crud::PAGE_INDEX),
              MenuItem::linkToCrud('Technologies', 'fas fa-drafting-compass', Technology::class)->setAction(Crud::PAGE_INDEX),
        ]);
    }
}
