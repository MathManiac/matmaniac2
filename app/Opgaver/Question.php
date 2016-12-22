<?php

namespace App\Opgaver;


abstract class Question
{
    public function Ask()
    {
        $questionMethod = "Questions";
        if (session()->has('chain'))
        {
            $chainLength = count(session('chain.list'));
            session()->put('chain.previous', session('chain.list')[$chainLength-1]);
            $questionIdentifier = questionIdentifierFromChain();
            $questionMethod = "followUpQuestionQ$questionIdentifier";

            foreach (session('chain.previous')['result'] as $variable => $result)
                session()->put('chain.results.' . $variable, $result);
        }
        $questionLength = count($this->$questionMethod());
        $select = rand(1, $questionLength);
        $question = $this->$questionMethod()[$select];
        #region check for missing values
        if (starts_with($questionMethod, 'followUpQuestion'))
        {
            $default = ['value', 'numbers'];
            foreach ($default as $d)
            {
                if ( ! array_key_exists($d, $question))
                    $question[$d] = session('chain.previous')[$d];
            }
        }
        #endregion
        $question['type'] = $select;
        \Debugbar::addMessage($question, 'Question');
        return $question;
    }
}