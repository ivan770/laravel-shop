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
    Route::get('/item/{item}', 'ItemController@show');
    Route::get('/items/search', 'ItemController@search');
    Route::get('/items/{subcategory}', 'ItemController@index');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::resource('category', 'CategoryController')->only(['index']);
});

Route::group(['middleware' => ['auth:api', 'scope:cart']], function () {
    Route::resource('cart', 'CartController')->only(['index', 'show', 'store', 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'scope:wishlist']], function () {
    Route::resource('wishlist', 'WishlistController')->only(['index', 'store', 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'scope:address']], function () {
    Route::resource('address', 'AddressController')->only(['index', 'store', 'update', 'destroy']);
});

Route::group(['middleware' => ['auth:api', 'scope:payment'], 'prefix' => 'payment'], function () {
    Route::resource('cards', 'Payment\CardController')->only(['index', 'store', 'update', 'destroy']);
    Route::get('charge/{addrid}', 'Payment\ChargeController@charge');
});