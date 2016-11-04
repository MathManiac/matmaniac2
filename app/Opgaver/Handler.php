<?php

namespace App\Opgaver;

use App\Opgaver\Fractions\MultiplyTwoFracs;

class Handler
{
    public $types = [
        10 => MultiplyTwoFracs::class,
        11 => OneFrac::class
    ];

    public function sendToCorrection($question, $resultat)
    {
        $arguments = explode(',', $question);
        $input = $arguments;
        unset($input[0]);
        $input = array_values($input);
        $result = null;

        $instance = new $this->types[$arguments[0]];
        return $instance->validateQuestion($input, $resultat);
    }

    public function getQuestion($subExerciseId)
    {
        $instance = new $this->types[$subExerciseId];
        return $instance->Ask();
    }
}