<?php

namespace App\Controller\Admin;

use App\Entity\Question;
use Cassandra\Custom;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use function Symfony\Component\String\s;
use App\FormField\CustomField;
use App\Form\AnswerType;

class QuestionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Question::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('location_type'),
            ChoiceField::new('level')->setChoices(
                [
                    'Beginner' => Question::CONST_LEVEL_BEGINNER,
                    'Intermediate' => Question::CONST_LEVEL_INTERMEDIATE,
                    'Advanced' => Question::CONST_LEVEL_ADVANCED
                ]
            )->autocomplete(false),
            ChoiceField::new('type')->setChoices([
               'Default' => Question::CONST_TYPE_DEFAULT,
               'Parser'=>Question::CONST_TYPE_PARSER
            ]),
            TextareaField::new('name'),
            CollectionField::new('answers')
                ->setFormTypeOption('entry_type', AnswerType::class)
//            AssociationField::new('answers')->setFormTypeOptions(['by_reference' => false])


        ];
    }


}
