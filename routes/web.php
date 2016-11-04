<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('formel-samling', [
    'uses' => 'HomeController@formelSamling',
    'as' => 'formel-samling'
]);

Route::get('opgaver/{type?}', [
    'as' => 'opgaver',
    'uses' => 'HomeController@opgaver'
]);

Route::get('opgaver/{type}/{subtype}', [
    'uses' => 'HomeController@valgtOpgave',
    'as' => 'valgtOpgave'
]);

Route::post('tjek-resultat', [
    'uses' => 'HomeController@tjekResultat',
    'as' => 'tjek-resultat'
]);

Auth::routes();

Route::get('/home', 'HomeController@index');
