<?php

namespace App\Opgaver;

interface ResultInterface
{
    public function validateQuestion($input, $question);
}