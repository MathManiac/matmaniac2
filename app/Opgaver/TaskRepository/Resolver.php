<?php

namespace App\Opgaver\TaskRepository;

use App\Task;

class Resolver {

    public function generateFormula(Task $task)
    {
        if (session()->has('chain.shared'))
            extract(session('chain.shared'));
        eval($task->generator);
        preg_match_all('#\$[a-zA-Z0-9_]+#', $task->generator, $genVars);
        $genVars = $genVars[0];
        array_walk($genVars, function (&$value, $key)
        {
            $value = substr($value, 1);
        });
        $definedVars = [];
        foreach ($genVars as $var)
            $definedVars[$var] = $$var;
        session()->flash('previewVars', $definedVars);
        $numbers = [];
        $vNumbers = [];
        $options = $task->options;
        $undefined = [];
        foreach ($this->getGeneratorVariables($task) as $variable)
        {
            $var = substr($variable, 1);
            if ( ! isset($$var))
            {
                $undefined[] = $var;
                continue;
            }
            $numbers[$var] = $$var;
            $vNumbers[$variable] = $$var;
        }
        if (count($undefined))
            session()->flash('warning', 'The variable(s) ' . implode(', ', $undefined) . ' haven\'t been defined.');
        if (session()->has('chain.shared'))
        {
            $sharedVariables = session('chain.shared');
            $merge = [];
            foreach($sharedVariables as $variable => $content)
                $merge['$'.$variable] = round($content, 2);
            $vNumbers = array_merge($merge, $vNumbers);
        }
        $options['numbers'] = $numbers;
        $options['value'] = strtr($options['value'], $vNumbers);
        $options['text'] = strtr($task->name, $vNumbers);
        return $options;
    }

    public function getResultForInput($name, $task)
    {
        $requiredVariables = $this->getInputVariables($task);
        array_walk($requiredVariables, function (&$value, $key)
        {
            $value = '$answer' . studly_case($value);
        });
        if (session()->has('chain.shared'))
            extract(session('chain.shared'));
        if (session()->has('previewVars'))
            extract(session('previewVars'));
        else
            eval($task->generator);
        eval($task->validator);
        $askFor = "answer" . studly_case($name);
        if (isset($$askFor))
        {
            \Debugbar::addMessage($name . ': ' . $$askFor, 'Resultat');
            if(is_numeric($$askFor))
                $$askFor = round($$askFor, 2);
            return $$askFor;
        }
        return '';
    }

    public function getGeneratorVariables(Task $task)
    {
        preg_match_all('#\$[a-zA-Z0-9_]+#', $task->options['value'], $variables);
        return $variables[0];
    }

    public function getValidatorVariables(Task $task)
    {
        preg_match_all('#\$answer[A-Za-z0-9]+#', $task->validator, $variables);

        return $variables[0];
    }

    public function getInputVariables(Task $task, $withAppend = false)
    {
        $input = array_pluck($task->options['input'], 'name');
        if ($withAppend)
            array_walk($input, function (&$value, $key)
            {
                $value = '$input' . studly_case($value);
            });

        return $input;
    }

    public function getAnsweredVariables(Task $task)
    {
        preg_match_all('#\$[a-zA-Z0-9_]+#', $task->validator, $variables);
        $vars = $variables[0];
        $answeredVars = [];
        foreach ($vars as $var)
        {
            if (starts_with($var, '$answer'))
                $answeredVars[] = $var;
        }

        return $answeredVars;
    }

    public function getAllVariables(Task $task)
    {
        return array_merge($this->getGeneratorVariables($task), $this->getInputVariables($task, true));
    }

    public function allInputsAnswered(Task $task)
    {
        $answered = $this->getAnsweredVariables($task);
        $requiredVariables = $this->getInputVariables($task);
        array_walk($requiredVariables, function (&$value, $key)
        {
            $value = '$answer' . studly_case($value);
        });
        return count(array_diff($requiredVariables, $answered)) == 0;
    }
    
    public function generateQuestion($task, $withResults = false)
    {
        $question = [];
        if (session()->has('chain.shared'))
            extract(session('chain.shared'));
        eval($task->generator);
        eval($task->validator);
        $question['name'] = $task->name;
        foreach ($this->getGeneratorVariables($task) as $variable)
        {
            $var = substr($variable, 1);
            $vNumbers[$variable] = $$var;
        }
        foreach ($this->getValidatorVariables($task) as $variable)
        {
            $var = substr($variable, 1);
            $answerNumbers[$variable] = $$var;
        }
        $question['value'] = strtr($task->options['value'], $vNumbers);
        foreach($task->options['input'] as $input)
        {
            if($withResults)
            {
                $answer = 'answer' . studly_case($input['name']);
                $input['answer'] = round($$answer, 2);
            }
            $question['input'][] = $input;
        }
        return $question;
    }

    public function chain(Task $task, $withCurrent = false)
    {
        $parents = [];
        if($withCurrent)
            $parents[] = $task;
        $parent = $task->previous()->first();
        while($parent != null)
        {
            $parents[] = $parent;
            $parent = $parent->previous()->first();
        }
        $parents = array_reverse($parents);
        return $parents;
    }

    public function getQuestionAndAnswer(Task $task, $withCurrent = false)
    {
        $chain = $this->chain($task, $withCurrent);
        $chainList = [];
        $sharedVariables = [];
        foreach($chain as $task)
        {
            $genVars = $this->getGeneratorVariables($task);
            $valVars = $this->getValidatorVariables($task);
            $variables = array_merge($genVars, $valVars);
            eval($task->generator);
            eval($task->validator);
            $varContext = [];
            foreach($variables as $variable)
            {
                $variable = substr($variable, 1);
                $varContext[$variable] = $$variable;
            }
            $chainList[$task->id]['variables'] = $varContext;
            $sharedVariables = array_merge($sharedVariables, $varContext);
            foreach($task->options['input'] as $input)
            {
                $answer = 'answer' . studly_case($input['name']);
                if(is_numeric($$answer))
                    $input['answer'] = round($$answer, 2);
                else
                    $input['answer'] = $$answer;
                $chainList[$task->id]['input'][] = $input;
            }
            $vNumbers = [];
            foreach($sharedVariables as $var => $replacement)
            {
                if(is_numeric($replacement))
                    $replacement = round($replacement, 2);
                $vNumbers['$'.$var] = $replacement;
            }
            $chainList[$task->id]['value'] = strtr($task->options['value'], $vNumbers);
            $chainList[$task->id]['name'] = strtr($task->name, $vNumbers);
        }
        return ['list' => $chainList, 'shared' => $sharedVariables];
    }
}