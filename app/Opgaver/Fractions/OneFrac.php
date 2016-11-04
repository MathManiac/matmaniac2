<?php

namespace App\Opgaver\Fractions;

use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class OneFrac implements QuestionInterface
{


    public function Ask()
    {
        $a = rand(1,15);
        $b = rand(1,15);
        $c = rand(1,15);

        return [
            'question' => "{{$a}\\over{$b}} \cdot {$c}",
            'numbers' => [$a, $b, $c]
        ];
    }
}