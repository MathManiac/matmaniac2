<?php

namespace App\Opgaver\Equations;

use App\Opgaver\Question;
use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class XWithBracets extends Question implements QuestionInterface, ResultInterface
{
    public function Questions()
    {
        $b = rand(2,15);
        $c = rand(1,5);

        return [
            1 => [
                'value' => "$c (x + $c) = $b",
                'numbers' => [$b, $c],
            ],
            2 => [
                'value' => "$c (x - $c) = $b",
                'numbers' => [$b, $c]
            ],
            3 => [
                'value' => "-$c (x - $c) = $b",
                'numbers' => [$b, $c]
            ],
            4 => [
                'value' => "$c (-x + $c) = $b",
                'numbers' => [$b, $c]
            ]
        ];
    }

    public function validateQuestion($input, $question)
    {
        $input = (float)$input['result'];

        switch ($question['type']) {

            case 1:

                $b = $question['numbers'][0];
                $c = $question['numbers'][1];

                $res = round(($b - $c*$c)/$c, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 2:

                $b = $question['numbers'][0];
                $c = $question['numbers'][1];

                $res = round(($b + $c*$c)/$c, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 3:

                $b = $question['numbers'][0];
                $c = $question['numbers'][1];

                $res = round(($b - $c*$c)/-$c, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
            case 4:

                $b = $question['numbers'][0];
                $c = $question['numbers'][1];

                $res = round(($c*$c-$b)/$c, 2);
                \Debugbar::addMessage($res, 'result');
                \Debugbar::addMessage($input, 'Input');
                return ['result' => $res == round($input, 2)];
        }
    }


}