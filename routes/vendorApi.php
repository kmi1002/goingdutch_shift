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

Route::get('vendor/{vendor_id}/menu', 'MenuItemController@menus')->name('vendor.menu.index');
Route::get('vendor/{vendor_id}/menu/{menu_id}', 'MenuItemController@menu')->name('vendor.menu.show');
Route::put('vendor/{vendor_id}/menu/{menu_id}/recommend', 'MenuItemController@menuRecommend')->name('vendor.menu.recommend');
Route::put('vendor/{vendor_id}/menu/{menu_id}/active', 'MenuItemController@menuActive')->name('vendor.menu.active');



//        Route::get('vendor/excel/import', 'VendorController@import')->name('vendor.excel.import');

// User
Route::apiResource('user', 'UserController')->only([
    'index'
]);

// Article
Route::apiResource('article', 'ArticleController')->only([
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

Route::get('{vendor_id}/pos', 'PosController@index')->name('vendor.pos.index');

Route::put('{vendor_id}/pos/change', 'PosController@change')->name('vendor.pos.change');
Route::put('{vendor_id}/pos/refund', 'PosController@refund')->name('vendor.pos.refund');
