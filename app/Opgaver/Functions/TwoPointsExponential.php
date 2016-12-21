<?php

namespace App\Opgaver\Functions;

use App\Opgaver\Input;
use App\Opgaver\Question;
use App\Opgaver\QuestionInterface;
use App\Opgaver\ResultInterface;

class TwoPointsExponential extends Question implements QuestionInterface, ResultInterface
{

    public function Questions()
    {
        $a = rand(2, 4);
        $b = rand(7, 15);
        $c = rand(1, 6);
        $d = rand(1,8);
        return  [
            1 => [
                'text' => 'Find a for eksponentielle funktion.',
                'value' => "A($a; $b) \\; B($c ; $d)",
                'numbers' => [$a, $b, $c, $d],
                'input' => [
                    new Input('a')
                ],
                'follow-up' => true
            ]
        ];
    }

    #region Question 1
    public function followUpQuestionQ1()
    {
        $previousQuestion = session('chain.previous');
        $a = $previousQuestion['numbers'][0];
        $b = $previousQuestion['numbers'][1];
        return [
            1 => [
                'value' => '',
                'text' => "Find b for den ekspontielle funktioin.",
                'input' => [
                    new Input('b')
                ],
                'follow-up' => true
            ]
        ];
    }

    public function followUpValidationQ1($input, $question)
    {
        $input = (float)$input['b'];

        $a = $question['numbers'][0];
        $b = $question['numbers'][1];
        $resA = session('chain.results.a');
        $res = round($b/pow($resA,$a),2);
        \Debugbar::addMessage($res, 'Resultat');
        return ['result' => $res == round($input, 2)];
    }
    #endregion

    #region Question 1 Follow Up 1
    public function followUpQuestionQ1_1()
    {
        $resA = session('chain.results.a');
        $resB = session('chain.results.b');
        return [
            1 => [
                'value' => '',
                'text' => "Funktionen hedder f(x) = $$resB \\cdot $resA^x$, <br>
                    er funktionen voksende eller aftagende?",
                'follow-up' => true
            ]
        ];
    }
    #endregion

    public function validateQuestion($input, $question)
    {
        $input = (float)$input['a'];

        switch ($question['type']) {

            case 1:
                $a = $question['numbers'][0];
                $b = $question['numbers'][0];
                $c = $question['numbers'][1];
                $d = $question['numbers'][3];
                $res = round(($d - $b)/($c - $a), 2);
                \Debugbar::addMessage($res, 'Resultat');
                return ['result' => $res == round($input, 2)];

        }
    }
}