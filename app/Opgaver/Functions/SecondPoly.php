<?php

namespace App\Opgaver\Functions;

use App\Opgaver\Input;
use App\Opgaver\Question;
use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;


class SecondPoly extends Question implements QuestionInterface, ResultInterface
{

    public function Questions()
    {
        $a = rand(2, 4);
        $b = rand(7, 15);
        $c = rand(1, 6);
        $questions = [
            1 => [
                'value' => "f(x)=$a x^2+$b x+$c",
                'numbers' => [$a, $b, $c]
            ],
            2 => [
                'value' => "f(x)=$a x^2-$b x-$c",
                'numbers' => [$a, -$b, -$c]
            ],
            3 => [
                'value' => "f(x)=-$a x^2-$b x-$c",
                'numbers' => [-$a, -$b, -$c]
            ],
            4 => [
                'value' => "f(x)=-$a x^2+$b x+$c",
                'numbers' => [-$a, $b, $c]
            ],
            5 => [
                'value' => "f(x)=$a x^2-$b x+$c",
                'numbers' => [$a, $b, $c]
            ]
        ];
        foreach ($questions as &$question) {
            $question['input'] = [
                new Input('x1', 'X1', 'Ingen løsninger, klik "Tjek resultat"'),
                new Input('x2', 'X2')
            ];
        }
        return $questions;
    }

    public function validateQuestion($input, $question)
    {
        $a = $question['numbers'][0];
        $b = $question['numbers'][1];
        $c = $question['numbers'][2];
        $x1res = round(-$b+sqrt(pow($b,2)-4*$a*$c)/2*$a, 2);
        $x2res = round(-$b-sqrt(pow($b,2)-4*$a*$c)/2*$a, 2);
        $x1 = round($input['x1'], 2) == $x1res;
        $x2 = round($input['x2'], 2) == $x2res;
        \Debugbar::addMessage($x1res, 'x1');
        \Debugbar::addMessage($x2res, 'x2');
        \Debugbar::addMessage($input, 'Input');
        return [
            'x1' => $x1,
            'x2' => $x2
        ];
    }
}