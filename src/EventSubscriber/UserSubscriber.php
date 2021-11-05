<?php

namespace App\EventSubscriber;

use App\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Security;

class UserSubscriber implements EventSubscriberInterface
{


    /**
     * @var UserService
     */
    private $userService;

    /**
     * @var RequestStack
     */
    private $requestStack;


    public function __construct(UserService $userService, RequestStack $requestStack)
    {

        $this->userService = $userService;

        $this->requestStack = $requestStack;
    }

    public static function getSubscribedEvents()
    {
        return [
            RequestEvent::class => 'onKernelRequest'
        ];
    }

    public function onKernelRequest(RequestEvent $event)
    {

        if(preg_match('/^\/map/', $event->getRequest()->getPathInfo())){
            $this->userService->checkUser();
        }

    }
}