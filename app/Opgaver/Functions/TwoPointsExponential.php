<?php

namespace App\Opgaver\Functions;

use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class TwoPointsExponential implements QuestionInterface, ResultInterface
{

    public function Ask()
    {
        $i = rand(1, 4);
        switch ($i) {

        }
    }

    public function Questions()
    {
        return [
            1 => [
                ''
            ]
        ];
    }

    public function validateQuestion($input, $question)
    {
        // TODO: Implement validateQuestion() method.
    }
}