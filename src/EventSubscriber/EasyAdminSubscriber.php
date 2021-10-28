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

    public function saveAnswers(AfterEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if (!($entity instanceof Question)) {
            return;
        }

        foreach($entity->getPreAnswers() as $answer)
        {
            $answer->setQuestion($entity);
            $this->em->persist($answer);
        }

        $this->em->flush();
    }

    public function loadAnswers(AfterEntityBuiltEvent $event)
    {
        $entity = $event->getEntity()->getInstance();


        if (!($entity instanceof Question)) {
            return;
        }



    }
}