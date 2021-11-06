<?php

namespace App\Controller\Admin;

use App\Entity\LocationType;
use App\Entity\Question;
use App\Entity\Location;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Area;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('QuizzMap admin board');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Areas', 'fas fa-list', Area::class);
        yield MenuItem::linkToCrud('Location Types', 'fas fa-list', LocationType::class);
        yield MenuItem::linkToCrud('Locations', 'fas fa-list', Location::class);
        yield MenuItem::linkToCrud('Questions', 'fas fa-list', Question::class);
        yield MenuItem::linkToCrud('Users', 'fas fa-user', User::class);
    }
}
