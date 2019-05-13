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

Route::group(['middleware' => ['auth:api', 'scope:cart']], function () {
    Route::resource('cart', 'CartController')->only(['index', 'show', 'store']);
    Route::delete('/cart/{cart_id}/{id}', 'CartController@destroy');
});

Route::group(['middleware' => ['auth:api', 'scope:wishlist']], function () {
    Route::resource('wishlist', 'WishlistController')->only(['index', 'store', 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'scope:address']], function () {
    Route::resource('address', 'AddressController')->only(['index', 'store', 'update', 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'scope:oauth', 'oauth'], 'prefix' => 'oauth'], function () {
    Route::get('/redirect/{provider}', 'Auth\APIController@redirect');
    Route::get('/callback/{provider}', 'Auth\APIController@callback');
});