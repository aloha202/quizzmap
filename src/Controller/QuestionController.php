<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\AnswerRepository;
use App\Service\QuestionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    #[Route('/question/{id}.html', name: 'question')]
    public function show(Question $question, Request $request, AnswerRepository $answerRepository, QuestionService $questionService): Response
    {
        $answer = null;
        if($request->isMethod('post')){
            $answer_id = $request->request->get('answer_id');
            if($answer_id) {
                $answer = $answerRepository->find($answer_id);
            }
        }
        $tpl = 'default';
        switch ($question->getType())
        {
            case Question::CONST_TYPE_PARSER:
                $tpl = 'parser';
                if($request->isMethod('post')){
                    $questionService->processRequest($request);
                }
                break;
        }
        return $this->render('question/show_' . $tpl . '.html.twig', [
            'question' => $question,
            'currentAnswer' => $answer
        ]);
    }
}
