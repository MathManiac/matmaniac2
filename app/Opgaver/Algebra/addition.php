<?php

namespace App\Opgaver\Algebra;

class Addition
{
    public $a;
    public $b;
    public $result;

    public function __construct($input, $result)
    {
        $this->a = $input[0];
        $this->b = $input[1];
        $this->result = $result;
    }

    public function validateResult()
    {
        return $this->a + $this->b == $this->result;
    }
}