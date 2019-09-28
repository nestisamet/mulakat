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
Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function () {
    Route::post('signin', 'AuthController@signin');
    Route::post('refresh', 'AuthController@refresh');
});
Route::group(['prefix'=>'account', 'namespace'=>'Account'], function () {
    Route::post('signup', 'SignupController@create');
});


/**
 * authentication gerektiren endpointler
 */
Route::group(['middleware' => ['jwt-auth']], function () {
    Route::get('test', function () {
        return response()->json(['everything' => 'is cool']);
    });
    Route::group(['prefix'=>'auth', 'namespace'=>'Auth'], function () {
        Route::delete('signout', 'AuthController@signout');
        Route::post('changePassword', 'PasswordController@update');
    });
    /**
     * yalnizca otorize olan ebeveyne ait ogrenciler
     */
    Route::get('student/my', 'Student\StudentController@my');
    /**
     * tum ogrenciler
     */
    Route::resource('student', 'Student\StudentController');
    Route::group(['prefix'=>'account', 'namespace'=>'Account'], function () {
        Route::resource('profile', 'ProfileController');
    });
});
