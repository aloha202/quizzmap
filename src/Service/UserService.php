<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class UserService
{

    /**
     * @var RequestStack
     */
    private $requestStack;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager)
    {

        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
    }

    public function checkUser():void
    {

        $session = $this->requestStack->getSession();

        if(!$session->has('User')){
            $session->set('User', $this->createAnon());
        }

    }


    public function createAnon():User
    {
        $user = new User;
        $user->setEmail(sha1(microtime()) . '@anonimus.com');
        $user->setStatus(User::STATUS_ANON);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();


        return $user;
    }

}