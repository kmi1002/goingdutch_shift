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
//
//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::namespace('v1')->name('v1.')->group(function () {
    Route::post('vendor/payment', 'PaymentController@store')->name('vendor.payment.store');
    Route::post('vendor/payment/easypay', 'PaymentController@easypay')->name('vendor.payment.easypay');
    Route::post('vendor/payment/success', 'PaymentController@success')->name('vendor.payment.success');

    Route::post('vendor/payment/card/callback', 'PaymentController@ksnetCallback')->name('vendor.payment.card.ksnetCallback');


    Route::post('vendor/cart', 'CartController@store')->name('vendor.cart.store');
    Route::post('vendor/cart/quick', 'CartController@quick')->name('vendor.cart.quick');
    Route::delete('vendor/cart/{id}', 'CartController@destroy')->name('vendor.cart.destory');
    Route::post('vendor/cart/all', 'CartController@destroyAll')->name('vendor.cart.destoryAll');
});