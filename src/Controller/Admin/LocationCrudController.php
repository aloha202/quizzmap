<?php

namespace App\Controller\Admin;

use App\Entity\Location;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Location::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('parent'),
            AssociationField::new('area'),
            AssociationField::new('type'),
            TextField::new('name'),
            TextField::new('position'),
            NumberField::new('num_of_questions'),
            BooleanField::new('is_active'),
            NumberField::new('pass_rate')->onlyOnForms(),
            NumberField::new('difficulty_from')->onlyOnForms(),
            NumberField::new('difficulty_to')->onlyOnForms(),
            NumberField::new('min_rating')->onlyOnForms(),
            NumberField::new('min_points')->onlyOnForms(),

            CollectionField::new('locations')->onlyOnIndex()
        ];
    }

}
