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

Route::get('/laravel', function () {

    // load legacy session, but don't allow it to be updated in laravel code
    session_start();
    session_write_close();

    // FIXME real auth
    Auth::onceUsingId($_SESSION['user_id']);

    $user = Auth::getUser();
    \App\Preflight::checkNotifications();
    Toastr::info('Welcome ' . ($user->realname ?: $user->username));

    \LibreNMS\Config::loadFromDatabase();

    return view('laravel');
});

Route::post('/ajax/set_resolution', 'AjaxController@setResolution');


// Debugbar routes need to be here because of catch-all
if (config('app.env') !== 'production' && config('app.debug')) {
    Route::get('/_debugbar/assets/stylesheets', [
        'as' => 'debugbar-css',
        'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
    ]);

    Route::get('/_debugbar/assets/javascript', [
        'as' => 'debugbar-js',
        'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
    ]);

    Route::get('/_debugbar/open', [
        'as' => 'debugbar-open',
        'uses' => '\Barryvdh\Debugbar\Controllers\OpenController@handler'
    ]);
}

// Legacy routes
Route::any('/api/v0/{path?}', 'LegacyController@api')->where('path', '.*');
Route::any('/{path?}', 'LegacyController@index')->where('path', '.*');

// should never reach this
Route::any('/{any?}', function ($any = null) {
    echo "Failed to find path\n";
    echo $any . PHP_EOL;
    dd($any);
})->where('any', '.*');
