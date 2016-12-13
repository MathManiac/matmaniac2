<?php

namespace App\Opgaver;


abstract class Question
{
    public function Ask()
    {
        $questionLength = count($this->Questions());
        $select = rand(1, $questionLength);
        $question = $this->questions()[$select];
        $question['type'] = $select;
        \Debugbar::addMessage($question, 'Question');
        return $question;
    }
}