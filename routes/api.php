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

        Route::middleware('auth:api')->group(function () {
            Route::group(['prefix' => 'data'], function () {
                Route::get('changelog', 'DataController@getChangelog');
            });
            Route::group(['prefix' => 'features'], function () {
                Route::get('/', 'FeaturesController@index');
                Route::get('/{feature}', 'FeaturesController@show');
                Route::put('/{feature}', 'FeaturesController@update');
                Route::post('setActive/{feature}/{active?}', 'FeaturesController@setFeatureActive');
            });
        });
        Route::group(['prefix' => 'receive_data'], function () {
            Route::post('sensor/{serial}', 'ReceiveDataController@saveSensorData');
            Route::post('camera/{serial}', 'ReceiveDataController@saveCameraData');
            Route::post('backlight/{serial}', 'ReceiveDataController@saveBacklightData');
            Route::post('wifi/{serial}', 'ReceiveDataController@saveWifiData');
        });
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//ToDo::Rejestracja

//ToDo::Konfiguracja + pobieranie funkjconalności z API(v2)
