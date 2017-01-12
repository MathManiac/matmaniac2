<?php

namespace App\Providers;

use App\Opgaver\TaskRepository\Resolver;
use App\Opgaver\TaskResolver;
use App\SubExerciseType;
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

        View::composer('admin.tasks.partials.preview', function($view){
            $taskResolver = app(Resolver::class);
            $task = $view->getData()['task'];
            $currentTask = $taskResolver->generateFormula($task);
            $view->with(['preview'=>$currentTask, 'resolver' => $taskResolver]);
        });

        View::composer('admin.tasks.master', function($view){
            $task = $view->getData()['task'];
            $subExercise = request()->has('new-category') ?
                SubExerciseType::find(request('new-category')) :
                (request()->has('previous') ? Task::find(request('previous'))->subExerciseType()->first() :
                $task->SubExerciseType()->first());
            $exercise = $subExercise->exerciseType()->first();
            $breadcrumbs = [
                'category' => $exercise,
                'subCategory' => $subExercise
            ];
            $view->with(['breadcrumbs'=>$breadcrumbs]);
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
