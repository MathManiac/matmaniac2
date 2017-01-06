<?php

namespace App\Http\Middleware;

use App\Opgaver\TaskRepository\Resolver;
use App\Task;
use Closure;

class ChainMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $task = $request->route('task');
        if(is_null($task) && ! $request->has('previous'))
            return $next($request);
        if ($request->has('previous'))
        {
            $task = new Task();
            $task->chained_to = request('previous');
        }
        if(is_null($task->chained_to))
            return $next($request);
        $taskResolver = app()->make(Resolver::class);
        $chain = $taskResolver->chain($task, false);
        $chainList = [];
        $sharedVariables = [];
        foreach($chain as $task)
        {
            $genVars = $taskResolver->getGeneratorVariables($task);
            $valVars = $taskResolver->getValidatorVariables($task);
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
                $input['answer'] = round($$answer, 2);
                $chainList[$task->id]['input'][] = $input;
            }
            $vNumbers = [];
            foreach($genVars as $replacement)
            {
                $var = substr($replacement, 1);
                $vNumbers[$replacement] = $$var;
            }
            $chainList[$task->id]['value'] = strtr($task->options['value'], $vNumbers);
            $chainList[$task->id]['name'] = $task->options['text'];
        }
        session()->flash('chain.list', $chainList);
        session()->flash('chain.shared', $sharedVariables);

        return $next($request);
    }
}
