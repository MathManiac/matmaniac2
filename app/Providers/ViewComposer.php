<?php

namespace App\Providers;

use App\Opgaver\TaskResolver;
use App\Task;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposer extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('formelSamling.master', function($view){
            $routeParams = Route::current()->parameters();
            $currentCategory = array_key_exists('category', $routeParams) ? $routeParams['category']->id : -1;
            $currentSubject = array_key_exists('subject', $routeParams) ? $routeParams['subject']->id : -1;
            $view->with(compact('currentCategory', 'currentSubject'));
        });

        View::composer('admin.tasks.partials.chain', function($view){
            $parent = isset($task) ? $parent = $task->previous()->first() : Task::find(request('previous'));
            $previous = [];
            $previous[] = $parent->getQuestion(true);
            while( ! is_null($parent->previous()->first()))
            {
                dd("LOL");
            }
            $view->with(compact('previous'));
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
