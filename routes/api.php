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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * authentication gerektirmeyen endpointler
 */
Route::group(['prefix'=>'account', 'namespace'=>'Account'], function () {
    Route::post('signup', 'SignupController@create');
});


/**
 * authentication gerektiren endpointler
 */