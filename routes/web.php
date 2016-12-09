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

Route::group(['prefix' => 'opgaver'], function () {

    Route::get('{type?}', [
        'as' => 'opgaver',
        'uses' => 'HomeController@opgaver'
    ]);

    Route::get('{type}/{subtype}', [
        'uses' => 'HomeController@valgtOpgave',
        'as' => 'valgtOpgave'
    ]);

    Route::get('{type}/{subtype}/start', [
        'uses' => 'HomeController@startOpgave',
        'as' => 'startResultSet'
    ]);

    Route::get('{type}/{subtype}/end', [
        'uses' => 'HomeController@slutOpgave',
        'as' => 'endResultSet'
    ]);

    Route::get('{type}/{subtype}/skip-question', [
        'uses' => 'TaskController@skipQuestion',
        'as' => 'skip-opgave'
    ]);
});


Route::post('tjek-resultat', [
    'uses' => 'HomeController@tjekResultat',
    'as' => 'tjek-resultat'
]);

Auth::routes();

Route::get('/home', 'HomeController@index');

//Route til billeder
