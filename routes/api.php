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

Route::middleware(['auth:api', 'scope:info'])->get('/user', 'Auth\APIController@getSelf');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('/item/{id}', 'ItemController@show');
    Route::get('/items/{id}', 'ItemController@index');
});
