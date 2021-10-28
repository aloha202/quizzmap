<?php

namespace App\FormField;

use Doctrine\Common\Collections\Collection;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Field\FieldInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\FieldTrait;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use App\Form\AnswerType;

class CustomField implements FieldInterface
{

    use FieldTrait;


    /**
     * @param string|false|null $label
     */
    public static function new(string $propertyName, $label = null): self
    {
        return (new self())
            ->setProperty($propertyName)
            ->setLabel($label)
            ->setTemplatePath('admin/form_field/custom.html.twig')
            ->setFormType(CollectionType::class)
            ->addCssClass('field-array')
            ->addJsFiles('bundles/easyadmin/form-type-collection.js')
            ->setDefaultColumns('col-md-7 col-xxl-6')
;
    }

}