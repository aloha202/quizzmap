<?php

namespace App\EventSubscriber;

use App\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class UserSubscriber implements EventSubscriberInterface
{


    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {


        $this->userService = $userService;
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {
        $this->userService->checkUser();
    }
}