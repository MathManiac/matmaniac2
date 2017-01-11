<?php

function questionIdentifierFromChain()
{
    $identifiers = [];
    foreach (session('chain.list') as $question)
        $identifiers[] = $question['type'];
    return implode('_', $identifiers);
}

function replaceTaskVariables($string, $task)
{
    $variables = [];
    if (session()->has('chain.shared'))
        $variables = session('chain.shared');
    $taskResolver = app(\App\Opgaver\TaskRepository\Resolver::class);

    dd($taskResolver, $variables);
}