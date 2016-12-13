<?php

namespace App\Opgaver;

use App\Opgaver\Equations\XOnOneSide;
use App\Opgaver\Equations\XOnBothSides;
use App\Opgaver\Fractions\MultiplyTwoFracs;
use App\Opgaver\Equations\XWithBracets;
use App\Opgaver\Equations\XInNominator;
use App\Opgaver\Functions\SecondPoly;
use App\Opgaver\Functions\TwoPointsExponential;

class Handler
{
    public $types = [
        //Fractions
        20 => MultiplyTwoFracs::class,
        21 => OneFrac::class,
        //Equations
        40 => XOnOneSide::class,
        41 => XOnBothSides::class,
        42 => XWithBracets::class,
        43 => XInNominator::class,
        //Functions
        60 => TwoPointsExponential::class,
        61 => SecondPoly::class
    ];

    public function sendToCorrection(Array $question, $resultat)
    {
        $instance = new $this->types[$question['subType']->id];
        return $instance->validateQuestion($resultat, $question);
    }

    public function getQuestion($subExerciseId)
    {
        $instance = new $this->types[$subExerciseId->id];
        $question = $instance->Ask();
        if ( ! array_key_exists('input', $question))
            $question['input'][] = new Input('a');
        return $question;
    }
}