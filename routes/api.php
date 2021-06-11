<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('ping', 'PingController@actionPingStatus');

# Request API Managers
Route::group(['prefix' => 'auth'],function() {
    Route::post('login', 'AuthController@login');
    Route::group(['middleware' => 'auth.jwt'], function () {
        Route::get('info', 'AuthController@me');
        Route::post('logout', 'AuthController@logout');
        Route::post('token-refresh', 'AuthController@refresh');
    });
});
