<?php

namespace App\Controller\Admin;

use App\Entity\LocationType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LocationType::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('parent_location_type')
            ->formatValue(function ($value){
                return $value;
            }),

            TextField::new('name'),
        ];
    }
}
