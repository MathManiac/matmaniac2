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

Route::group(['prefix' => 'formel-samling'], function ()
{
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
        'as'   => 'showResults'
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

Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function ()
{

    Route::group(['prefix' => 'tasks', 'as' => 'tasks.'], function ()
    {
        Route::get('overview', [
            'as'   => 'overview',
            'uses' => 'TaskController@overview'
        ]);

        Route::get('list/{category}/{subcategory?}', [
            'as'   => 'list',
            'uses' => 'TaskController@list'
        ]);

        Route::post('list/{subCategory}/create-sub-category', [
            'as'   => 'create-sub-category',
            'uses' => 'TaskController@createSubCategory'
        ]);

        Route::get('download', [
            'as'   => 'download',
            'uses' => 'TaskController@download'
        ]);

        Route::get('create/{task?}', [
            'as'   => 'create',
            'uses' => 'TaskController@create'
        ]);

        Route::post('create/{task?}', [
            'as'   => 'doCreate',
            'uses' => 'TaskController@doCreate'
        ]);

        Route::get('{task}/inputs', [
            'as'   => 'inputs',
            'uses' => 'TaskController@inputs'
        ]);

        Route::post('{task}/inputs/update', [
            'as'   => 'updateInputs',
            'uses' => 'TaskController@updateInputs'
        ]);

        Route::get('{task}/inputs/add-input', [
            'as'   => 'addInput',
            'uses' => 'TaskController@addInput'
        ]);

        Route::post('{task}/inputs', [
            'as'   => 'saveInput',
            'uses' => 'TaskController@saveInput'
        ]);

        Route::get('{task}/inputs/action', [
            'as'   => 'inputAction',
            'uses' => 'TaskController@inputAction'
        ]);

        Route::get('{task}/inputs/add-selection', [
            'as'   => 'addInputSelection',
            'uses' => 'TaskController@addInputSelection'
        ]);

        Route::get('{task}/validation', [
            'as'   => 'validation',
            'uses' => 'TaskController@validation'
        ]);

        Route::post('{task}/validation', [
            'as'   => 'saveValidation',
            'uses' => 'TaskController@saveValidation'
        ]);

        Route::get('{task}/archive', [
            'as'   => 'archive',
            'uses' => 'TaskController@archive'
        ]);

        Route::get('{task}/run-tests', [
            'as'   => 'runTests',
            'uses' => 'TaskController@runTests'
        ]);

        Route::get('{task}/final', [
            'as'   => 'final',
            'uses' => 'TaskController@final'
        ]);

        Route::post('{task}/final', [
            'as'   => 'changeStatus',
            'uses' => 'TaskController@updateStatus'
        ]);
    });
});

//Route til billeder
