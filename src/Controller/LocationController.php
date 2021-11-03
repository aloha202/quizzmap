<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\QuestionRepository;
use App\Service\QuestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location/{id}.html', name: 'location')]
    public function index(Location $location, QuestionRepository $questionRepository, Request $request, QuestionService $questionService): Response
    {
        if($request->isMethod('post')){
            $questionService->processAnsweredQuestions($request->request->get('question'));
        }
        $questions = $questionRepository->findByLocation($location);
        return $this->render('location/show.html.twig', [
            'location' => $location,
            'questions' => $questions
        ]);
    }
}
