<?php

namespace App\Opgaver;

use App\Task;

class TaskResolver
{
    public function generateFormula(Task $task)
    {
        eval($task->generator);
        preg_match_all('#\$[a-zA-Z0-9_]+#', $task->options['value'], $variables);
        $numbers = [];
        $vNumbers = [];
        $options = $task->options;
        foreach($variables[0] as $variable)
        {
            $var = substr($variable, 1);
            $numbers[$var] = $$var;
            $vNumbers[$variable] = $$var;
        }

        $options['numbers'] = $numbers;
        $options['value'] = strtr($options['value'], $vNumbers);
        return $options;
    }
}