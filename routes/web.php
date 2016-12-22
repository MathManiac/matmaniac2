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

Route::get('/', function ()
{
    return view('welcome');
});

Route::group(['prefix' => 'formel-samling'], function(){
    Route::get('{category?}', [
        'uses' => 'FormelSamlingController@index',
        'as'   => 'formel-samling'
    ]);

    Route::get('{category}/{subject}', [
        'uses' => 'FormelSamlingController@valgt',
        'as'   => 'formel-samling-valgt'
    ]);
});

Route::group(['prefix' => 'opgaver'], function ()
{
    Route::get('results/{resultSet?}', [
        'uses' => 'TaskController@results',
        'as' => 'showResults'
    ]);

    Route::get('{type?}', [
        'as'   => 'opgaver',
        'uses' => 'TaskController@opgaver'
    ]);

    Route::get('{type}/{subtype}', [
        'uses' => 'TaskController@valgtOpgave',
        'as'   => 'valgtOpgave'
    ]);

    Route::get('{type}/{subtype}/start', [
        'uses' => 'TaskController@startOpgave',
        'as'   => 'startResultSet'
    ]);

    Route::get('{type}/{subtype}/end', [
        'uses' => 'TaskController@slutOpgave',
        'as'   => 'endResultSet'
    ]);

    Route::get('{type}/{subtype}/skip-question', [
        'uses' => 'TaskController@skipQuestion',
        'as'   => 'skip-opgave'
    ]);
});


Route::post('tjek-resultat', [
    'uses' => 'TaskController@tjekResultat',
    'as'   => 'tjek-resultat'
]);

Auth::routes();

Route::get('/home', 'HomeController@index');

//Route til billeder
