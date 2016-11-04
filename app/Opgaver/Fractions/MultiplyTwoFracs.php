<?php

namespace App\Opgaver\Fractions;

use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class MultiplyTwoFracs implements ResultInterface, QuestionInterface
{
    public $a;
    public $b;
    public $c;
    public $d;

    public $result;

    public function validateResult($input, $result)
    {
        $this->a = $input[0];
        $this->b = $input[1];
        $this->c = $input[2];
        $this->d = $input[3];
        $this->result = $result;
        // TODO: Implement validateResult() method.
        $res =($this->a*$this->c)/($this->b*$this->d);
        return $this->result==$res;
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
    }
}