<?php

namespace App\Opgaver\Equations;

use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class XOnBothSides implements QuestionInterface, ResultInterface
{

    public function Ask()
    {
        $a = rand(2,15);
        $b = rand(2,15);
        $c = rand(1,5);
        $d = rand(6,11);
        $i = rand(1,4);
        $question = [];
        switch ($i) {
            case 1:
                $question = [
                    'question.value' => "$c x + $a = $b + $d x",
                    'question.numbers' => [$a, $b, $c, $d]
                ];
                break;
            case 2:
                $question = [
                    'question.value' => "$d x - $a = $b + $c x",
                    'question.numbers' => [$a, $b, $c, $d]
                ];
                break;
            case 3:
                $question = [
                    'question.value' => "$c x + $a = $b - $d x",
                    'question.numbers' => [$a, $b, $c, $d]
                ];
                break;
            case 4:
                $question = [
                    'question.value' => "$d x - $a = $b - $c x",
                    'question.numbers' => [$a, $b, $c, $d]
                ];
                break;
        }
        $question['question.type'] = $i;
        return $question;
    }

    public function validateQuestion($input, $question)
    {
        $input = (float)$input;
        switch ($question['question.type']) {
            case 1:
                $a = $question['question.numbers'][0];
                $b = $question['question.numbers'][1];
                $c = $question['question.numbers'][2];
                $d = $question['question.numbers'][3];
                $res = round(($b - $a)/($c - $d), 2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return $res == round($input, 2);
            case 2:
                $a = $question['question.numbers'][0];
                $b = $question['question.numbers'][1];
                $c = $question['question.numbers'][2];
                $d = $question['question.numbers'][3];
                $res = round(($b+$a)/($d - $c),2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return $res == round($input, 2);
            case 3:
                $a = $question['question.numbers'][0];
                $b = $question['question.numbers'][1];
                $c = $question['question.numbers'][2];
                $d = $question['question.numbers'][3];
                $res = round(($b - $a)/($c + $d), 2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return $res == round($input, 2);
            case 4:
                $a = $question['question.numbers'][0];
                $b = $question['question.numbers'][1];
                $c = $question['question.numbers'][2];
                $d = $question['question.numbers'][3];
                $res = round(($b+$a)/($d + $c),2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return $res == round($input, 2);
        }
    }
}