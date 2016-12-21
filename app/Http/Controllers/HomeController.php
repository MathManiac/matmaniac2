<?php

namespace App\Http\Controllers;

use App\ExerciseType;
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
        session()->forget(['result-set', 'question', 'chain']);

        return redirect()->route('opgaver')->withSuccess('Opgaven blev afsluttet.');
    }

    public function valgtOpgave(ExerciseType $type, SubExerciseType $subtype, Handler $mathHandler)
    {
        if (session()->has('result-set'))
        {
            if (session('result-set')->sub_exercise_type_id != $subtype->id)
                return view('opgaver.ongoing', compact('subtype'));
            if ( ! session()->has('question'))
            {
                $question = $mathHandler->getQuestion($subtype);
                session()->put('question', $question);
                session()->put('question.subType', $subtype);
            } else
                $question = session('question');
            $opg = $question['value'];
            $text = array_key_exists('text', $question) ? $question['text'] : null;
            $input = $question['input'];
        }

        return view('opgaver.valgt', compact('opg', 'type', 'subtype', 'input', 'text'));
    }

    public function tjekResultat(Handler $mathHandler)
    {
        $question = session('question');
        $response = request('results');
        if ( ! session()->has('instance'))
        {
            $q = new Question();
            $q->result_set_id = session('result-set')->id;
            $q->tries = 0;
            $q->question = $question['value'];
            $q->save();
            session()->put('instance', $q);
        } else
            $q = session('instance');
        $q->tries = $q->tries + 1;
        $checked = $mathHandler->sendToCorrection($question, $response);
        $correct = 0;
        foreach($checked as $answer => $c)
            if ($c) $correct++;
        if ($correct == count($checked))
        {
            if ($question['follow-up'])
            {
                $question['result'] = $response;
                session()->push('chain.list', $question);
            }
            else
                session()->forget('chain');
            $q->input = json_encode($response);
            session()->forget('question');
        }
        $q->save();
        return $checked;
    }

    public function opgaver(ExerciseType $type)
    {
        return view('opgaver.home', compact('type'));
    }
}
