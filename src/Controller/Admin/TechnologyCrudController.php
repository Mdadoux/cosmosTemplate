<?php

namespace App\Controller\Admin;

use App\Entity\Technology;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TechnologyCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Technology::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            BooleanField::new('active'),
            ImageField::new('img', 'Image')
            ->setBasePath('uploads/images/technologies')
            ->setUploadDir('public/uploads/images/technologies')
            ->setSortable(false),
        ];
    }
}
