<?php

namespace App\Twig;

use App\Entity\Question;
use App\Entity\UserQuestionAnswer;
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
            new TwigFilter('asAnsweredHtml', [$this, 'asAnsweredHtml'], ['is_safe' => ['html']]),
        ];
    }

    public function getFunctions(): array
    {
        return [
            //new TwigFunction('function_name', [$this, 'doSomething']),
        ];
    }

    public function asHtml(Question $question, $parameter_name = null):string
    {
        return $this->questionService->getParsedHtml($question, $parameter_name);
    }

    public function asAnsweredHtml(UserQuestionAnswer $uqa):string
    {
        $matches_input = $this->questionService->getMatchesInput($uqa->getText());
        $matches_combo = $this->questionService->getMatchesCombo($uqa->getText());

        $replacements = [];

        $answerData = unserialize($uqa->getAnswerText());

        foreach($matches_combo[0] as $key => $value){
            $answer = $answerData['combo'][$key];
            $isCorrect = strpos($value, '[' . $answer . ']') != -1;
            $color = $isCorrect ? 'green' : 'red';
            $replacements[$value] = "<span style='color: $color'>$answer</span>";
        }
        foreach($matches_input[0] as $key => $value){
            $answer = $answerData['input'][$key];
            $isCorrect = strpos($value,  $answer ) != -1;
            $color = $isCorrect ? 'green' : 'red';
            $replacements[$value] = "<span style='color: $color'>$answer</span>";
        }

        return nl2br(strtr($uqa->getText(), $replacements));
    }
}
