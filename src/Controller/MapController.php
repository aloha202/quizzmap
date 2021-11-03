<?php

namespace App\Controller;

use App\Repository\AreaRepository;
use App\Repository\LocationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MapController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function index(LocationRepository $locationRepository, AreaRepository $areaRepository): Response
    {
        $area = $areaRepository->find(1);
        $locations = $locationRepository->findBy(['area' => $area]);
        return $this->render('map/index.html.twig', [
            'locations' => $locations,
        ]);
    }
}
