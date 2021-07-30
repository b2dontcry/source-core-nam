<?php

use Illuminate\Support\Facades\Route;

Route::prefix('dashboard_admin_23644466')->middleware('web')->group(function () {
    Route::get('login', 'LoginController@index')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::get('change-password', 'ChangePasswordController@showChangePasswordPage')->name('change-password');
    Route::post('change-password', 'ChangePasswordController@changePassword');
});

Route::prefix('api')->middleware('api')->group(function () {
    Route::post('v1/login', 'ApiLoginController@login');
    Route::post('v1/refresh-token', 'ApiLoginController@refreshToken');
    Route::get('v1/logout', 'ApiLoginController@logout')->middleware('auth:api');

    Route::get('unauthorized', 'ApiLoginController@unauthorized')->name('unauthorized');
});
