<?php

namespace App\Controller\Admin;

use App\Entity\LocationType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class LocationTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LocationType::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
