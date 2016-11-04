<?php

namespace App\Opgaver;

interface ResultInterface
{
    public function validateResult($input, $result);
}