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

        return view('formel-samling');
    }

    public function opgaver($type, $subtype)
    {
        if ( ! session()->exists('result-set'))
        {
            $resultSet = new ResultSet();
            $resultSet->user_id = auth()->id();
            $resultSet->sub_exercise_type_id = $subtype;
            $resultSet->save();
            session()->put('result-set', $resultSet);
        }

        $a = rand(1, 11);
        $b = rand(1, 11);
        $opg = "$a + $b";
        $question = "1,$a,$b";
        $hash = md5($opg . 'mm');
        return view('opgaver', compact('opg', 'hash', 'question'));
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
}
