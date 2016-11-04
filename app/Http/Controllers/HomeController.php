<?php

namespace App\Http\Controllers;

use App\Opgaver\Handler;
use App\Question;
use App\ResultSet;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function formelSamling()
    {
        $a = rand(10, 11);
        $b = rand(1, 11);
        $c = rand(1, 11);
        $opg = "f(x) = $a x^2+$b x-$c ";
        $opg1 = "{$c}\\over{$a}";
        $opg2 = "\\sqrt{{$a}\\cdot{$c}}";

        $question = "1,$a,$b,$c";
        $hash = md5($opg . 'mm');
        return view('formel-samling', compact('opg', 'opg1', 'opg2', 'hash', 'question'));
    }

    public function valgtOpgave($type, $subtype, Handler $mathHandler)
    {
        if ( ! session()->exists('result-set'))
        {
            $resultSet = new ResultSet();
            $resultSet->user_id = auth()->id();
            $resultSet->sub_exercise_type_id = $subtype;
            $resultSet->save();
            session()->put('result-set', $resultSet);
        }
        $question = $mathHandler->getQuestion($subtype);

        $opg = $question['question'];
        $q = [];
        $q[] = $subtype;
        $q = implode(array_merge($q, $question['numbers']));
        $hash = md5($q . 'mm');
        return view('opgaver.valgt', compact('opg', 'hash', 'q'));
    }

    public function tjekResultat(Handler $mathHandler)
    {
        $q = request('question');
        if ($mathHandler->sendToCorrection($q, request('resultat')))
        {
            $question = new Question();
            $question->result_set_id = session('result-set')->id;
            $question->tries = 0;
            $question->question = $q;
            $question->save();
        }

    }

    public function opgaver()
    {
        return view('opgaver.home');
    }
}
