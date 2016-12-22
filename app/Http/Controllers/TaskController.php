<?php

namespace App\Http\Controllers;

use App\Question;
use App\ExerciseType;
use App\Opgaver\Handler;
use App\QuestionInput;
use App\ResultSet;
use App\SubExerciseType;

class TaskController extends Controller
{
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
        if ($resultSet->questions()->count() > 0) {
            $resultSet->ended_at = date('Y-m-d H:i:s');
            $resultSet->save();
        }
        else
            $resultSet->delete();
        session()->forget(['result-set', 'question', 'chain', 'instance']);

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
            $q->value = $question['value'];
            if (isset($q->text))
                $q->text = $question['text'];
            if (session()->has('chain.last-instance'))
                $q->previous_id = session('chain.last-instance')->id;

            $q->save();
            session()->put('instance', $q);
        } else
            $q = session('instance');
        $checked = $mathHandler->sendToCorrection($question, $response);
        $correct = 0;
        foreach($checked as $answer => $c)
            if ($c) $correct++;
        $correctResponse = $correct == count($checked);
        #region Log Inputs for the question
        $q->inputs()->save(new QuestionInput([
            'input' => json_encode($response),
            'correct' => $correct
        ]));
        #endregion
        if ($correctResponse)
        {
            if (array_key_exists('follow-up', $question))
            {
                $question['result'] = $response;
                session()->put('chain.last-instance', $q);
                session()->push('chain.list', $question);
            }
            else
                session()->forget('chain');
            session()->forget(['question','instance']);
        }
        return $checked;
    }

    public function opgaver(ExerciseType $type)
    {
        return view('opgaver.home', compact('type'));
    }

    public function skipQuestion($type, $subtype)
    {
        if (session()->has('question')) {
            if (!session()->has('instance')) {
                $q = new Question();
                $q->question = session('question')['value'];
                $q->result_set_id = session('result-set')->id;
            } else
                $q = session('instance');
            $q->skipped = true;
            $q->save();
            session()->forget(['question','chain','instance']);
        }
        return redirect()->route('valgtOpgave', [$type, $subtype]);
    }

    public function results(ResultSet $resultSet)
    {
        $resultSet = session('result-set')->load('subExerciseType');

        $results = $resultSet->questions()->with('inputs')->get();
        return view('opgaver.results', compact('results', 'resultSet'));
    }
}
