<?php

namespace App\Providers;

use App\Opgaver\TaskResolver;
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
