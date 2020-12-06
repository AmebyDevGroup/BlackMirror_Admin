<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Route;

Auth::routes(['register' => true, 'verify' => true]);

Route::get('/', 'Controller@welcome')->name('home');
Route::get('/pomoc', 'Controller@help')->name('help');

Route::get('test', function () {
    dd(\Carbon\Carbon::now()->setTimezone('Europe/Warsaw')->format('Y-m-d H:i:s'));
});
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', 'AdminPanelController@getConfigurationPage')
        ->name('admin.getConfiguration');
    Route::get('external-accounts', 'AdminPanelController@getExternalAccountsPage')
        ->name('admin.getExternalAccounts');
    Route::get('devices', 'AdminPanelController@getDevices')
        ->name('admin.getDevices');
    Route::get('test-websockets', 'AdminPanelController@getWebsocketsTestPage')
        ->name('admin.getWebsocketsTest');
    Route::get('help', 'AdminPanelController@getHelpPage')
        ->name('admin.getHelp');
    Route::get('changelog', 'AdminPanelController@getChangelogPage')
        ->name('admin.getChangelog');
    Route::get('info', 'AdminPanelController@getInfoPage')
        ->name('admin.info');
    Route::get('contact', 'AdminPanelController@getContactForm')
        ->name('admin.contactUs');
    Route::post('contact', 'AdminPanelController@sendContactForm')
        ->name('admin.contactUs');

    Route::prefix('configuration')->middleware('verified')->group(function () {
        Route::post('setPageMode/{mode?}', 'ConfigurationController@setPageMode')
            ->name('configuration.setPageMode');
        Route::get('getForm/{feature}', 'ConfigurationController@getConfigurationForm')
            ->name('configuration.getConfigurationForm');
        Route::post('sendForm/{feature}', 'ConfigurationController@sendConfigurationForm')
            ->name('configuration.sendConfigurationForm');
        Route::post('setActive/{feature}/{active?}', 'ConfigurationController@setActive')
            ->name('configuration.setActive');
        Route::get('getAir/stations', 'ConfigurationController@getAirStations')
            ->name('configuration.getAirStations');
        Route::get('taskFolders/{provider}', 'ConfigurationController@getTasksFolder')
            ->name('configuration.getTaskFolders');
    });
    Route::get('test-websockets/{feature}', 'WebsocketTestController@getData')
        ->name('testWebsocketsData');

    Route::prefix('external-accounts')->middleware('verified')->group(function () {
        Route::prefix('microsoft')->group(function () {
            Route::get('/zaloguj', 'Auth\MicrosoftAuthController@signin')
                ->name('microsoft.signin');
            Route::get('/wyloguj', 'Auth\MicrosoftAuthController@signout')
                ->name('microsoft.signout');
        });
        //ToDo:Zrobić logowanie google
        Route::prefix('google')->group(function () {
            Route::get('/zaloguj', 'Auth\GoogleAuthController@redirectToProvider')
                ->name('google.signin');
            Route::get('/wyloguj', 'Auth\GoogleAuthController@signout')
                ->name('google.signout');
        });
    });
});

Route::prefix('callbacks')->group(function () {
    Route::get('/microsoft', 'Auth\MicrosoftAuthController@callback');
    Route::get('/google', 'Auth\GoogleAuthController@handleProviderCallback');
});
