<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([ 'namespace' => 'Api'], function () {
    Route::group(['prefix' => 'v1', 'namespace' => 'V1'], function () {
        Route::post('login', 'AuthController@login');

        Route::middleware('auth:api')->group(function() {
            Route::group(['prefix' => 'data'], function () {
                Route::get('changelog', 'DataController@getChangelog');
            });
            Route::group(['prefix' => 'features'], function () {
                Route::post('setActive/{feature}/{active?}', 'FeaturesController@setFeatureActive');
            });
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//ToDo::Włącz/Wyłącz funkcjonalność

//ToDo::Pobieranie changelog

//ToDo::Formularz kontaktowy

//ToDo::Logowanie

//ToDo::Rejestracja

//ToDo::Konfiguracja + pobieranie funkjconalności z API(v2)
