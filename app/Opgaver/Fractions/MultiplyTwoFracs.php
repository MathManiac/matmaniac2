<?php

namespace App\Opgaver\Fractions;

use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class MultiplyTwoFracs implements ResultInterface, QuestionInterface
{
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

    public function Ask()
    {
        $a = rand(1,15);
        $b = rand(1,15);
        $c = rand(1,15);
        $d = rand(1,15);
        return [
            'question' => "{{$a}\\over{$b}} \cdot {{$c}\\over{$d}}",
            'numbers' => [$a, $b, $c, $d]
        ];

        /*$a = rand(1,30);
        if($a>15){
            $a = $a-31;
        }
        $b = rand(1,30);
        if($a>15){
            $b = $b-31;
        }
        $c = rand(1,30);
        if($c>15){
            $c = $c-31;
        }*/
        return [
            'question' => "{{$c}\over{($a + x)}} = $b",
            'numbers' => [$a, $b, $c]
        ];
    }
}