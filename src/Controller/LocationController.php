<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\UserQuizzTake;
use App\Repository\QuestionRepository;
use App\Service\QuestionService;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    #[Route('/location/{id}.html', name: 'location')]
    public function index(Location $location, QuestionRepository $questionRepository, Request $request, QuestionService $questionService): Response
    {
        if($request->isMethod('post')){
            $questionService->setLocation($location);
            if($questionService->processAnsweredQuestions($request->request->get('question'))){
                return $this->redirectToRoute('quizz_results', ['id' => $questionService->getUserQuizzTake()->getId()]);
            }
        }
        $questions = $questionRepository->findByLocation($location);
        return $this->render('location/show.html.twig', [
            'location' => $location,
            'questions' => $questions
        ]);
    }

    #[Route('/results/{id}.html', name: 'quizz_results')]
    public function results(UserQuizzTake $userQuizzTake, UserService $userService)
    {
        if($userService->getUser()->getId() != $userQuizzTake->getUser()->getId()){
            throw new NotFoundHttpException('Sorry, this page is unavailable');
        }
        return $this->render('location/results.html.twig', [
            'userQuizzTake' => $userQuizzTake
        ]);
    }
}
