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

Route::middleware('throttle:10,1')->group(function () {
    Route::prefix('v1')->name('api.v1.')->namespace('Api\v1')->group(function () {
        Route::post('', 'SubscribersController@index');
        Route::get('/{subscriber}', 'SubscribersController@show');
    });
});
