<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function skipQuestion($type, $subtype)
    {
        if (session()->has('question')) {
            if (!session()->has('instance')) {
                $q = new Question();
                $q->question = session('question')['value'];
                $q->result_set_id = session('result-set')->id;
                $q->tries = 0;
            } else
                $q = session('instance');
            $q->skipped = true;
            $q->save();
            session()->forget('question');
        }
        return redirect()->route('valgtOpgave', [$type, $subtype]);
    }
}
