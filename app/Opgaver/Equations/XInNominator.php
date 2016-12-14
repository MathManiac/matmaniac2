<?php

namespace App\Opgaver\Equations;

use App\Opgaver\Question;
use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class XInNominator extends Question implements QuestionInterface, ResultInterface
{

    public function Questions()
    {
        $a = rand(2,4);
        $b = rand(2,15);
        $c = rand(2,5);
        $d = rand(6,11);
        $e = rand(2,4);
        return [
            1 => [
                'value' => "{x + $d\over{$c}} = $b",
                'numbers' => [$b, $c, $d]
            ],
            2 => [
                'value' => "{x - $d\over{$c}} = $b",
                'numbers' => [$b, $c, $d]
            ],
            3 => [
                'value' => "{{$a}x - $d\over{$c}} = $b",
                'numbers' => [$a, $b, $c, $d]
            ],
            4 => [
                'value' => "{{$a}x + $d\over{$c}} = $b-$e x",
                'numbers' => [$a, $b, $c, $d, $e]
            ]
        ];
    }

    public function validateQuestion($input, $question)
    {
        $input = (float)$input['result'];

        switch ($question['type']) {

            case 1:
                //$a = $question['numbers'][0];
                $b = $question['numbers'][0];
                $c = $question['numbers'][1];
                $d = $question['numbers'][2];
                $res = round($c*$b-$d, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 2:
                $b = $question['numbers'][0];
                $c = $question['numbers'][1];
                $d = $question['numbers'][2];
                $res = round($c*$b+$d, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 3:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $res = round(($c*$b-$d)/$a, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 4:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $e = $question['numbers'][4];
                $res = round(($c*$b-$d)/($a+$c*$e), 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
        }
    }
}