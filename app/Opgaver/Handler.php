<?php

namespace App\Opgaver;

class Handler
{
    public function sendToCorrection($question, $resultat)
    {
        $arguments = explode(',', $question);
        $input = $arguments;
        unset($input[0]);
        $input = array_values($input);
        switch ($arguments[0])
        {
            case 1:
                return new Algebra\Addition($input, $resultat);
                break;
            case 2:
                return new Algebra\Substraction($input, $resultat);
        }
    }
}