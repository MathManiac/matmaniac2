<?php

namespace App\Opgaver\Equations;

use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class XOnOneSide implements QuestionInterface, ResultInterface
{

    public function Ask()
    {
        $a = rand(1,15);
        $b = rand(1,15);
        $c = rand(1,15);
        $d = rand(1,15);
        return [
            'question' => "{{$c}{($a + x)}} = $b",
            'numbers' => [$a, $b, $c, $d]
        ];
    }

    public function validateQuestion($input, $question)
    {
        $a = $question['numbers'][0];
        $b = $question['numbers'][1];
        $c = $question['numbers'][2];
        $d = $question['numbers'][3];
        $input = (float)$input;
        $res =($a*$c)/($b*$d);
        return $input==round($res,2);
    }
}