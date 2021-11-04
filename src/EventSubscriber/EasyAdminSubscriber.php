<?php

namespace App\EventSubscriber;


use App\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityBuiltEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class EasyAdminSubscriber implements EventSubscriberInterface
{

    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    public static function getSubscribedEvents()
    {
        return [
          //  AfterEntityUpdatedEvent::class => ['saveAnswers'],
        //    AfterEntityBuiltEvent::class => ['loadAnswers']
        ];
    }

}