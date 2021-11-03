<?php

namespace App\Service;

use App\Entity\Question;
use Symfony\Component\HttpFoundation\Request;

class QuestionService
{

    private $pattern_input = "/\[\[(.*?)\]\]/";
    private $pattern_combo = "/\{\{(.*?)\}\}/";

    private $parameter_name = 'answers';

    private $requestParams = null;

    public function __construct()
    {
    }

    public function processRequest(Request $request)
    {
        $this->requestParams = $request->request->get($this->parameter_name);
    }

    public function getParsedHtml(Question $question):string
    {

        $matches_input = $this->getMatchesInput($question);
        $matches_combo = $this->getMatchesCombo($question);

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

    public function getMatchesInput(Question $question):?array
    {
        preg_match_all($this->pattern_input, $question, $matches);
        return $matches;
    }

    public function getMatchesCombo(Question $question):?array
    {
        preg_match_all($this->pattern_combo, $question, $matches);
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
}