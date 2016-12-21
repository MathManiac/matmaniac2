<?php

namespace App\Opgaver\Fractions;

use App\Opgaver\Question;
use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class OneFrac extends Question implements ResultInterface, QuestionInterface
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
                'value' => "{{$a}\\over{$b}} \cdot {$c}",
                'numbers' => [$a, $b, $c, $d]
            ],
            2 => [
                'value' => "{{$a}\\over{-$b}} \cdot {$c}",
                'numbers' => [$a, -$b, $c, $d]
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
                $res = round(($a*$c)/($b), 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 2:
                $a = $question['numbers'][0];
                $b = $question['numbers'][1];
                $c = $question['numbers'][2];
                $d = $question['numbers'][3];
                $res = round(($a*$c)/($b), 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
        }
    }
}