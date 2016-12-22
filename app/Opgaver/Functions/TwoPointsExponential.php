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
        $b = rand(1, 5);
        $c = rand(5, 9);
        $d = rand(6,14);
        return  [
            1 => [
                'text' => 'Find a for eksponentielle funktion.',
                'value' => "A($a ; $b) \\; B($c ; $d)",
                'numbers' => [$a, $b, $c, $d],
                'input' => [
                    new Input('a')
                ],
                'follow-up' => true
            ],
        ];
    }

    #region Question 1
    public function followUpQuestionQ1()
    {
        $previousQuestion = session('chain.previous');
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
        return ['b' => $res == round($input, 2)];
    }
    #endregion

    #region Question 1 Follow Up 1
    public function followUpQuestionQ1_1()
    {
        $resA = session('chain.results.a');
        $resB = session('chain.results.b');
        $input = new Input('development', 'Bestem udviklingen');
        $input->type = 'select';
        $input->options = ['decreasing', 'increasing'];
        return [
            1 => [
                'value' => '',
                'text' => "Funktionen hedder f(x) = $$resB \\cdot $resA^x$, <br>
                    er funktionen voksende eller aftagende?",
                'follow-up' => true,
                'input' => [$input]
            ]
        ];
    }

    public function followUpValidationQ1_1($input, $question)
    {
        $input = $input['development'];
        $resA = session('chain.results.a');
        \Debugbar::addMessage($resA > 1 ? 'increasing' : 'decreasing', 'Resultat');
        return ['development' => ($resA > 1 && $input == 'increasing') || ($resA < 1 && $input == 'decreasing')];
    }
    #endregion

    public function followUpQuestionQ1_1_1()
    {
        return [
            1 => [
                'value' => '',
                'text' => "Med hvor mange procent?",
                'input' => [new Input('percent')]
            ]
        ];
    }

    public function followUpValidationQ1_1_1($input, $question)
    {
        $input = (float)$input['percent'];
        $resA = session('chain.results.a');
        $per = $resA-1;
        if($per < 0)
        {
            $per*=(-1);
        }
        \Debugbar::addMessage($per);
        return ['percent' => $per == $input];
    }



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
                return ['a' => $res == round($input, 2)];

        }
    }
}