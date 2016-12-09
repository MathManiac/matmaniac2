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
       // $c = rand(1,15);
       // $d = rand(1,15);
        $i = rand(1,2);
        if ($i == 1) {
            return [
                'question' => "x + $a = $b",
                'numbers' => [$a, $b],
                'type' => $i
            ];
        } elseif ($i == 2) {
            return [
                'question' => "x - $a = $b",
                'numbers' => [$a, $b],
                'type' => $i
            ];
        }
        /*return [
            'question' => "x + $a = $b",
            'numbers' => [$a, $b]
        ];*/
    }

    public function validateQuestion($input, $question)
    {
        dd($question);
        $a = $question['numbers'][0];
        $b = $question['numbers'][1];

        //$c = $question['numbers'][2];
        //$d = $question['numbers'][3];
        $input = (float)$input;
        /*if($i == 1) {
            $res =$b-$a;
        } elseif ($i == 2) {
            $res =$b+$a;
        }*/

        return $input==round($res,2);
    }
}