<?php

// User
Route::namespace('Vendor')->prefix('vendor')->name('vendor.')->group(function () {
    // Auth
        Route::namespace('Auth')->name('auth.')->group(function () {
            // login
            Route::get('login', 'LoginController@loginForm')->name('login.form')->middleware('web');
            Route::post('login', 'LoginController@login')->name('login');

            // logout
            Route::get('logout', 'LoginController@logout')->name('logout');
        });

    // Dashboard
        Route::resource('dashboard', 'DashboardController')->only([
            'index'
        ]);

        Route::get('pos/prepare', 'PosController@prepare')->name('pos.prepare');
        Route::get('pos/approve', 'PosController@approve')->name('pos.approve');
        Route::get('pos/completed', 'PosController@completed')->name('pos.completed');

        Route::resource('payment', 'PaymentController')->only([
            'index'
        ]);


    // Vendor
        Route::get('info', 'InfoController@show')->name('info.show');
    //Route::resource('vendor', 'VendorController')->only([
    //    'index', 'show', 'edit'
    //]);

    // Vendor
        Route::resource('menu', 'MenuController')->only([
            'index', 'show', 'edit'
        ]);

        Route::resource('qr', 'QRController')->only([
            'index', 'show', 'edit'
        ]);

    // Manager
        Route::resource('manager', 'ManagerController');
});