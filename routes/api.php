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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'admin'], function () {
    //User Filters
    Route::post('filter/users', 'Api\UsersController@filterUsers');
});

Route::group(['prefix' => 'user'], function () {
    //User CRUD
    Route::post('store', 'Api\UsersController@store');

    Route::group(['middleware' => 'auth:api'], function() {
        //Update User
        Route::post('update', 'Api\UsersController@update');

        //Update Hobbies
        Route::post('hobbies/update', 'Api\UsersController@updateHobbies');

        //User Detail
        Route::post('detail', 'Api\UsersController@show');

        //Delete User
        Route::post('delete', 'Api\UsersController@destroy');
    });
});

Route::group(['prefix' => 'auth'], function () {
    //Login
    Route::post('login', 'Api\AuthController@login');
  
    Route::group(['middleware' => 'auth:api'], function() {
        //Logged Out
        Route::get('logout', 'Api\AuthController@logout');

        //User Logged In Detail 
        Route::get('detail', 'Api\AuthController@user');
    });
});
