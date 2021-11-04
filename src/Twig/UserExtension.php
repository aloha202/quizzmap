<?php

namespace App\Twig;

use App\Service\UserService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class UserExtension extends AbstractExtension
{
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(UserService $userService)
    {

        $this->userService = $userService;
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/2.x/advanced.html#automatic-escaping
            // new TwigFilter('filter_name', [$this, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('User', [$this, 'doGetUser']),
        ];
    }

    public function doGetUser()
    {
        return $this->userService->getUser();
    }
}
