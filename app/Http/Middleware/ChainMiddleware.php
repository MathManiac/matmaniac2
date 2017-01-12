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
        $question = $taskResolver->getQuestionAndAnswer($task, false);
        session()->flash('chain.list', $question['list']);
        session()->flash('chain.shared', $question['shared']);

        return $next($request);
    }
}
