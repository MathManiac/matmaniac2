<?php

namespace App\Opgaver;

use App\Opgaver\Equations\XOnOneSide;
use App\Opgaver\Equations\XOnBothSides;
use App\Opgaver\Fractions\MultiplyTwoFracs;
use App\Opgaver\Equations\XWithBracets;
use App\Opgaver\Equations\XInNominator;
use App\Opgaver\Fractions\OneFrac;
use App\Opgaver\Functions\SecondPoly;
use App\Opgaver\Functions\TwoPointsExponential;
use App\Task;

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
        if($question['subType']->id == 999)
            return $this->sendToTestCorrection($question, $resultat);
        $instance = new $this->types[$question['subType']->id];
        if (session()->has('chain')) {
            //validate chain question
            $questionIdentifier = questionIdentifierFromChain();
            $validationMethod = "followUpValidationQ$questionIdentifier";
            $result = $instance->$validationMethod($resultat, $question);
        }
        else
            $result = $instance->validateQuestion($resultat, $question);
        if (config('app.debug'))
            \Debugbar::addMessage($resultat, 'Input');
        return $result;
    }

    public function getQuestion($subExerciseId)
    {
        if ($subExerciseId->id == 999)
            return $this->getTestQuestion($subExerciseId);
        $instance = new $this->types[$subExerciseId->id];
        $question = $instance->Ask();
        if (!array_key_exists('input', $question))
            $question['input'][] = new Input('result');
        return $question;
    }

    public function getTestQuestion($subExercise)
    {
        $tasks = Task::whereSubExerciseId($subExercise->id)->get()->all();
        $selectedTask = $tasks[array_rand($tasks)];
        eval($selectedTask->generator);
        $question['type'] = $selectedTask->id;
        $question = array_merge($question, $selectedTask->options);
        $question['input'] = $this->parseInput($selectedTask->options['input']);
        $numbers = [];
        $vNumbers = [];
        preg_match_all('#\$[a-zA-Z0-9_]+#', $question['value'], $variables);
        foreach($variables[0] as $variable)
        {
            $var = substr($variable, 1);
            $numbers[$var] = $$var;
            $vNumbers[$variable] = $$var;
        }
        $question['numbers'] = $numbers;
        $question['value'] = strtr($question['value'], $vNumbers);
        return $question;
    }

    /**
     * @param $inputArray
     */
    public function parseInput($inputArray)
    {
        $inputs = [];
        foreach($inputArray as $input)
        {
            if ($input['type'] == 'text')
            {
                unset($input['type']);
                $inp = new Input();
                foreach($input as $key => $value)
                {
                    $inp->$key = $value;
                }
                $inputs[] = $inp;
            }
        }
        return $inputs;
    }

    public function sendToTestCorrection(Array $question, $input)
    {
        extract($question['numbers']);
        foreach ($input as $inp => $value)
            ${'input'.studly_case($inp)} = $value;
        $task = Task::find($question['type']);
        eval($task->validator);
        $results = [];
        $correct = [];
        foreach($input as $inp => $value) {
            $results[$inp] = ${'result'.studly_case($inp)};
            $correct[$inp] = ${'result'.studly_case($inp)} == $value;
        }
        if (config('app.debug'))
        {
            \Debugbar::addMessage($results, 'Resultat');
            \Debugbar::addMessage($input, 'Input');
        }
        return $correct;
        //dd($question, $input);
    }

}