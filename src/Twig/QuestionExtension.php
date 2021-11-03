<?php

namespace App\Twig;

use App\Entity\Question;
use App\Service\QuestionService;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class QuestionExtension extends AbstractExtension
{
    /**
     * @var QuestionService
     */
    private $questionService;

    public function __construct(QuestionService $questionService)
    {

        $this->questionService = $questionService;
    }
    public function getFilters(): array
    {
        return [
            new TwigFilter('asHtml', [$this, 'asHtml'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            //new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function asHtml(Question $question):string
    {
        return $this->questionService->getParsedHtml($question);
    }
}
