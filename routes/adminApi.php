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

// Admin
Route::apiResource('manager', 'ManagerController');
Route::get('manager/check/{email}', 'ManagerController@emailCheck')->name('manager.check.email');
Route::put('manager/recovery/email', 'ManagerController@recovery')->name('manager.recovery.email');


// Vendor
Route::apiResource('vendor', 'VendorController');
Route::put('vendor/recovery/email', 'VendorController@recovery')->name('vendor.recovery.email');

Route::get('vendor/{vendor_id}/menu', 'MenuItemController@index')->name('vendor.menu.index');
Route::get('vendor/{vendor_id}/menu/{menu_id}', 'MenuItemController@show')->name('vendor.menu.menu')->where('menu_id', '[0-9]+');
Route::post('vendor/{vendor_id}/menu', 'MenuItemController@store');
Route::put('vendor/{vendor_id}/menu/{menu_id}', 'MenuItemController@update');
Route::delete('vendor/{vendor_id}/menu/{menu_id}', 'MenuItemController@destroy');
Route::put('vendor/{vendor_id}/menu/{menu_id}/recovery', 'MenuItemController@recovery');
Route::put('vendor/{vendor_id}/menu/{menu_id}/recommend', 'MenuItemController@recommend')->name('vendor.menu.recommend')->where('menu_id', '[0-9]+');;
Route::put('vendor/{vendor_id}/menu/{menu_id}/active', 'MenuItemController@active')->name('vendor.menu.active')->where('menu_id', '[0-9]+');;

Route::get('vendor/{vendor_id}/menu/group', 'MenuGroupController@index')->name('vendor.menu.group.index');
Route::get('vendor/{vendor_id}/menu/group/{group_id}', 'MenuGroupController@show')->name('vendor.menu.group.show');
Route::delete('vendor/{vendor_id}/menu/group/{group_id}', 'MenuGroupController@destroy');
Route::put('vendor/{vendor_id}/menu/group/{group_id}/recovery', 'MenuGroupController@recovery');
Route::put('vendor/{vendor_id}/menu/group/{group_id}/active', 'MenuGroupController@active')->name('vendor.menu.group.active')->where('group_id', '[0-9]+');;


Route::get('vendor/{vendor_id}/menu/option', 'OptionGroupController@index')->name('vendor.menu.option.index');
Route::get('vendor/{vendor_id}/menu/option/{option_id}', 'OptionGroupController@option')->name('vendor.menu.option.show');
Route::put('vendor/{vendor_id}/menu/option/{option_id}/active', 'OptionGroupController@active')->name('vendor.menu.option.active');


Route::get('vendor/{vendor_id}/menu/option/item', 'OptionItemController@items')->name('vendor.menu.option.item.index');
Route::get('vendor/{vendor_id}/menu/option/item/{item_id}', 'OptionItemController@item')->name('vendor.menu.option.item.show');
Route::put('vendor/{vendor_id}/menu/option/item/{item_id}/active', 'OptionItemController@active')->name('vendor.menu.option.item.active');


Route::get('vendor/excel/import', 'VendorController@import')->name('vendor.excel.import');

// User
Route::apiResource('user', 'UserController')->only([
    'index'
]);

// Article
Route::apiResource('article', 'ArticleController')->only([
    'index'
]);

// Payment
Route::apiResource('payment', 'PaymentController')->only([
    'index'
]);

Route::prefix('article')->name('article.')->group(function () {

    // Article - Group
    Route::get('group/tree', 'ArticleGroupController@tree')->name('group.tree');
    Route::apiResource('group', 'ArticleGroupController');
});

// Support
Route::apiResource('support', 'SupportController');
Route::get('support/{group}/revision', 'SupportController@revision')->name('support.revision');


// MenuItem
Route::apiResource('menu', 'MenuItemController')->only([
    'index'
]);
