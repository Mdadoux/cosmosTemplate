<?php

namespace App\Controller\Admin;

use App\Entity\Project;
use App\Form\ImgProjectsType;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProjectCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Project::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('Id')->hideOnForm(),
            TextField::new('title', 'Titre du projet'),
            TextField::new('slug'),
            BooleanField::new('active'),
            AssociationField::new('idClient', 'Client'),
            TextEditorField::new('description'),
            CollectionField::new('imgProjects', 'Images Projet')
                ->setEntryType(ImgProjectsType::class)
                ->onlyOnForms(),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Project) {
            return;
        }
        $entityInstance->setupdatedAt(new \DateTimeImmutable());
        if (!$entityInstance->getId()) {
            $entityInstance->setcreatedAt(new \DateTimeImmutable());
        }
        parent::persistEntity($em, $entityInstance);
    }
}
