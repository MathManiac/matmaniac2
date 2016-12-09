<?php

namespace App\Opgaver;

use App\Opgaver\Equations\XOnOneSide;
use App\Opgaver\Equations\XOnBothSides;
use App\Opgaver\Fractions\MultiplyTwoFracs;

class Handler
{
    public $types = [
        20 => MultiplyTwoFracs::class,
        21 => OneFrac::class,
        40 => XOnOneSide::class,
        41 => XOnBothSides::class
    ];

    public function sendToCorrection($question, $resultat)
    {
        $instance = new $this->types[$question['subType']];
        return $instance->validateQuestion($resultat, $question);
    }

    public function getQuestion($subExerciseId)
    {
        $instance = new $this->types[$subExerciseId];
        return $instance->Ask();
    }
}