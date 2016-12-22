<?php

namespace App\Http\Controllers;

use App\Category;
use App\Subject;
use Illuminate\Http\Request;

class FormelSamlingController extends Controller
{
    public function index(Category $category)
    {
        $a = rand(10, 11);
        $b = rand(1, 11);
        $c = rand(1, 11);
        $opg = "f(x) = $a x^2+$b x-$c ";
        $opg1 = "{$c}\\over{$a}";
        $opg2 = "\\sqrt{{$a}\\cdot{$c}}";

        $question = "1,$a,$b,$c";
        $hash = md5($opg . 'mm');

        return view('formelSamling.master', compact('opg', 'opg1', 'opg2', 'hash', 'question'));
    }

    public function valgt(Category $category, Subject $subject)
    {
        $columns = $subject->columns()->whereLocale(\App::getLocale())->orderBy('order')->get();
        return view('formelSamling.valgt', compact('category', 'subject', 'columns'));
    }
}
