<?php

namespace App\Opgaver\Equations;

use App\Opgaver\Question;
use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class XOnOneSide extends Question implements QuestionInterface, ResultInterface
{
    public function Questions()
    {
        $a = rand(2,15);
        $b = rand(2,15);
        $c = rand(1,5);
        $d = rand(6,11);
        return [
            1 => [
                'value' => "x + $c = $b",
                'numbers' => [$a, $b, $c, $d]
            ],
            2 => [
                'value' => "x - $c = $b",
                'numbers' => [$a, $b, $c, $d]
            ],
            3 => [
                'value' => "-x + $c = $b",
                'numbers' => [$a, $b, $c, $d]
            ],
            4 => [
                'value' => "$d x + $c = $b",
                'numbers' => [$a, $b, $c, $d]
            ]
        ];
    }

    public function validateQuestion($input, $question)
    {
        $input = (float)$input['result'];
        switch ($question['type']) {
            case 1:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $res = round($b - $c, 2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 2:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $res = round($b+$c,2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 3:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $res = round($c-$b,2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 4:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $res = round(($b-$c)/$d,2);
                \Debugbar::addMessage($res, 'Resultat');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
        }
    }
}