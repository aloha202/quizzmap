<?php

namespace App\Service;

use App\Entity\Question;
use App\Entity\Location;
use App\Entity\UserQuizzTake;
use App\Entity\UserQuestionAnswer;
use App\Repository\AnswerRepository;
use App\Repository\QuestionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class QuestionService
{

    private $pattern_input = "/\[\[(.*?)\]\]/";
    private $pattern_combo = "/\{\{(.*?)\}\}/";

    private $uqa_parser_delim_array = ';;';
    private $uqa_parser_delim_correct = '::';

    private $parameter_name = 'answers';

    private $requestParams = null;

    private $input_name = null;
    /**
     * @var QuestionRepository
     */
    private $questionRepository;
    /**
     * @var AnswerRepository
     */
    private $answerRepository;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @var Location
     */
    private $location;

    /**
     * @var UserQuizzTake
     */
    private $userQuizzTake;
    /**
     * @var UserService
     */
    private $userService;

    public function __construct(QuestionRepository $questionRepository, AnswerRepository $answerRepository,
                                EntityManagerInterface $entityManager, UserService $userService)
    {
        $this->questionRepository = $questionRepository;
        $this->answerRepository = $answerRepository;
        $this->entityManager = $entityManager;
        $this->userService = $userService;
    }

    public function setLocation(Location $location):void
    {
        $this->location = $location;
    }

    public function processRequest(Request $request)
    {
        $this->requestParams = $request->request->get($this->parameter_name);
    }

    public function processAnsweredQuestions($data):bool
    {
        $this->_createUserQuizzTake();

        $ids = array_keys($data);

        $questions = $this->questionRepository->findByIds($ids);

        $result = true;
        foreach($questions as $question){
            if(!$this->answerQuestion($question, $data[$question->getId()])){
                $result = false;
            }
        }
        if($result) {
            $this->userService->getUser()->addPoints($this->userQuizzTake->getPoints());
            $this->entityManager->flush();
        }
        return $result;
    }

    public function answerQuestion(Question $question, mixed $answerData):bool
    {
        if($question->getType() == Question::CONST_TYPE_DEFAULT){
            return $this->answerQuestionDefault($question, $answerData);
        }elseif($question->getType() == Question::CONST_TYPE_PARSER){
            return $this->answerQuestionParser($question, $answerData);
        }
        return false;
    }
    public function answerQuestionDefault(Question $question, ?int $answer_id):bool
    {
        if(!$answer_id){
            return false;
        }

        $answer = $this->answerRepository->find($answer_id);
        if(!$answer){
            return false;
        }

        $points = 0;
        if($answer->getIsCorrect()){
            $points = $question->getPoints();
        }

        $uqa = $this->_getUqa();
        $uqa->setAnswer($answer);
        $uqa->setQuestion($question);
        $uqa->setIsCorrect($answer->getIsCorrect());
        $uqa->setText($question->getName());
        $uqa->setAnswerText($answer->getName());
        $uqa->setQuestionType(Question::CONST_TYPE_DEFAULT);
        $uqa->setPoints($points);

        $this->userQuizzTake->addPoints($points);

        $this->entityManager->persist($uqa);
        return true;
    }

    public function answerQuestionParser(Question $question, array $data):bool
    {


        $matches_input = $this->getMatchesInput($question);
        $matches_combo = $this->getMatchesCombo($question);


        $correct = true;
        if(!empty($matches_combo[0])) {
            foreach ($matches_combo[0] as $key => $value){
                $answer = $data['combo'][$key];
                if(!$answer || strpos($value, '[' . $answer . ']') == -1){
                    $correct = false;
                    break;
                }
            }
        }
        if(!empty($matches_input[0])) {
            foreach ($matches_input[0] as $key => $value){
                $answer = $data['input'][$key];
                if(!$answer || strpos($value, $answer) == -1){
                    $correct = false;
                    break;
                }
            }
        }

        $points = $correct ? $question->getPoints() : 0;


        $uqa = $this->_getUqa();

        $uqa->setQuestion($question);
      //  $uqa->setText(join($this->uqa_parser_delim_array, $answerData));
        $uqa->setText($question->getName());
        $uqa->setAnswerText(serialize($data));
        $uqa->setQuestionType(Question::CONST_TYPE_PARSER);
        $uqa->setIsCorrect($correct);
        $uqa->setPoints($points);

        $this->userQuizzTake->addPoints($points);

        $this->entityManager->persist($uqa);

        return true;
    }



    public function getParsedHtml(Question $question, $parameter_name = null):string
    {
        if($parameter_name){
            $this->parameter_name = $parameter_name . '[' . $question->getId() . ']';
        }
        $matches_input = $this->getMatchesInput($question->getName());
        $matches_combo = $this->getMatchesCombo($question->getName());

        $replacements = [];

        if($matches_combo){
            foreach($matches_combo[1] as $key => $value){
                $html = $this->getComboHtml($value, $key);
                $replacements[$matches_combo[0][$key]] = $html;
            }
        }

        if($matches_input){
            foreach($matches_input[1] as $key => $value){
                $html = $this->getInputHtml($value, $key);
                $replacements[$matches_input[0][$key]] = $html;
            }
        }

        return strtr($question->getName(), $replacements);

    }

    public function getMatchesInput(string $question_text):?array
    {
        preg_match_all($this->pattern_input, $question_text, $matches);
        return $matches;
    }

    public function getMatchesCombo(string $question_text):?array
    {
        preg_match_all($this->pattern_combo, $question_text, $matches);
        return $matches;
    }

    public function getInputHtml(string $values, $name):string
    {
        $value = !empty($this->requestParams['input'][$name]) ? $this->requestParams['input'][$name] : '';
        $answeredStyle = $this->getAnsweredStyle($this->getIsAnswered($name, 'input', $values));
        return "<span class='input' $answeredStyle ><input type='text' name='{$this->parameter_name}[input][$name]' value='$value' ></span>";
    }

    public function getComboHtml(string $values, $name):string
    {
        $value = !empty($this->requestParams['combo'][$name]) ? $this->requestParams['combo'][$name] : '';
        $answeredStyle = $this->getAnsweredStyle($this->getIsAnswered($name, 'combo', $values));
        $html = "<span class='input' $answeredStyle ><select name='{$this->parameter_name}[combo][$name]'><option value=''></option>";
        $expl = explode('|', $values);
        foreach($expl as $v){
            if(!preg_match("/\d+/", $v)){
                $v = str_replace(['[', ']'], '', $v);
                $selected = $v == $value ? 'selected' : '';
                $html .= "<option value='$v' $selected >$v</option>";
            }
        }
        $html .= "</select></span>";
        return $html;
    }

    private function getIsAnswered($key, $type, $values):int
    {
        if(empty($this->requestParams[$type][$key])){
            return 0;
        }
        return $this->isCorrectAnswer($this->requestParams[$type][$key], $values, $type) ? 1 : -1;
    }

    private function isCorrectAnswer($answer, $values, $type):bool
    {
        $expl = explode('|', $values);

        foreach($expl as $v){
            if(preg_match("/\d+/", $v)){
               continue;
            }
            if($type == 'combo') {
                if('[' . $answer . ']' == $v){
                    return true;
                }
            }
            if($type == 'input')
            {
                if($answer == $v){
                    return true;
                }
            }
        }
        return false;

    }

    public function getAnsweredStyle($answered):string
    {
        switch ($answered){
            case 1:
                return "style='border: solid 2px green'";
            case 0:
                return "";
            case -1:
                return "style='border: solid 2px red'";
        }
    }

    private function _createUserQuizzTake():void
    {
        $User = $this->userService->getUser();

        $this->userQuizzTake = new UserQuizzTake();
        $this->userQuizzTake->setUser($User);
        $this->userQuizzTake->setLocation($this->location);
        $this->userQuizzTake->setCreatedAt(new \DateTime());
        $this->userQuizzTake->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($this->userQuizzTake);
    }

    private function _getUqa():UserQuestionAnswer
    {
        $User = $this->userService->getUser();

        $uqa = new UserQuestionAnswer();

        $uqa->setUser($User);
        $uqa->setCreatedAt(new \DateTime());
        $uqa->setUpdatedAt(new \DateTime());
        $uqa->setUserQuizzTake($this->userQuizzTake);

        return $uqa;
    }

    public function getUserQuizzTake():UserQuizzTake
    {
        return $this->userQuizzTake;
    }
}