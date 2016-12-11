<?php

namespace App\Http\Controllers;

use App\Opgaver\Handler;
use App\Question;
use App\ResultSet;
use App\SubExerciseType;
use Illuminate\Http\Request;

class HomeController extends Controller {

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

    public function startOpgave($type, $subtype)
    {
        #if(session()->exists('result-set'))
        #return
        $resultSet = new ResultSet();
        $resultSet->user_id = auth()->id();
        $resultSet->sub_exercise_type_id = $subtype;
        $resultSet->save();
        session()->put('result-set', $resultSet);

        return redirect()->route('valgtOpgave', [$type, $subtype]);
    }

    public function slutOpgave($type, $subtype)
    {
        $resultSet = session('result-set');
        $resultSet->ended_at = date('Y-m-d H:i:s');
        $resultSet->save();
        session()->forget('result-set');
        session()->forget('question');

        return redirect()->route('opgaver');
    }

    public function valgtOpgave($type, $subtype, Handler $mathHandler)
    {
        if (session()->has('result-set'))
        {
            if (session('result-set')->sub_exercise_type_id != $subtype)
                return view('opgaver.ongoing');
            if ( ! session()->has('question'))
            {
                $question = $mathHandler->getQuestion($subtype);
                session()->put('question', $question);
                session()->put('question.subType', $subtype);
            } else
                $question = session('question');
            $opg = $question['question.value'];
        }

        return view('opgaver.valgt', compact('opg', 'type', 'subtype'));
    }

    public function tjekResultat(Handler $mathHandler)
    {
        $question = session('question');
        $response = request('result');

        if ( ! session()->has('question.instance'))
        {
            $q = new Question();
            $q->result_set_id = session('result-set')->id;
            $q->tries = 0;
            $q->question = $question['question.value'];
            $q->save();
            session()->put('question.instance', $q);
        } else
            $q = session('question.instance');
        $q->tries = $q->tries + 1;
        if ($mathHandler->sendToCorrection($question, $response))
        {
            $q->input = $response;
            $q->save();
            session()->forget('question');

            return ['response' => true];
        } else
        {
            $q->save();

            return ['response' => false];
            //return redirect()->route('valgtOpgave', [$subType->exercise_type_id, $subType->id])->withMathError('incorrectAnswer');
        }
        //return redirect()->route('valgtOpgave', [$subType->exercise_type_id, $subType->id])->withMathSolution('correctAnswer');
    }

    public function opgaver()
    {
        return view('opgaver.home');
    }
}
