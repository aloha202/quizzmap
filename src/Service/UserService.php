<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Exception\UserNotFoundException;
use Symfony\Component\Security\Core\Security;

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

    private $user;
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(RequestStack $requestStack, EntityManagerInterface $entityManager,
                                UserRepository $userRepository)
    {

        $this->requestStack = $requestStack;
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public function checkUser():void
    {

        $session = $this->requestStack->getSession();

        if($session->has(Security::LAST_USERNAME)){
            $this->user = $this->userRepository->findOneBy(['email' => $session->get(Security::LAST_USERNAME)]);
            if(!$this->user){
                throw new UserNotFoundException("User not found in the database");
            }
        }else {

            if (!$session->has('user_id')) {
                $session->set('user_id', $this->createAnon());
            }

            if (!$this->user) {
                $this->user = $this->userRepository->find($session->get('user_id'));
            }
            if (!$this->user) {
                throw new UserNotFoundException("User not found in the database");
            }
        }
    //    $this->entityManager->persist($session->get('User'));

    }


    public function createAnon():int
    {
        $user = new User;
        $user->setEmail(sha1(microtime()) . '@anonimus.com');
        $user->setStatus(User::STATUS_ANON);
        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->user = $user;
        return $user->getId();
    }

    public function getUser()
    {
        return $this->user;
    }

}