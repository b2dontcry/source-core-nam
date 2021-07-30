<?php

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

Route::middleware(['auth:api'])->namespace('Api')->group(function () {

    // User
    Route::prefix('v1/user')->group(function () {
        Route::get('/', 'UserController@index');
        Route::post('/', 'UserController@store');
        Route::get('{id}', 'UserController@show');
        Route::put('{id}', 'UserController@update');
        Route::patch('{id}', 'UserController@updateStaus');
        Route::delete('{id}', 'UserController@destroy');
        Route::delete('{id}/force', 'UserController@forceDelete');
        Route::post('{id}/restore', 'UserController@restore');
    });

    // Group
    Route::prefix('v1/group')->group(function () {
        Route::get('/', 'GroupController@index');
        Route::post('/', 'GroupController@store');
        Route::get('{id}', 'GroupController@show');
        Route::put('{id}', 'GroupController@update');
        Route::delete('{id}', 'GroupController@destroy');
    });

    // History
    Route::prefix('v1/history')->group(function () {
        Route::get('/', 'HistoryController@index');
    });
});
