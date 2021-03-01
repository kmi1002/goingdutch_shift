<?php

Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function () {
    // Auth
    Route::namespace('Auth')->name('auth.')->group(function () {
        // login
        Route::get('login', 'LoginController@loginForm')->name('login.form');
        Route::post('login', 'LoginController@login')->name('login');

        // logout
        Route::get('logout', 'LoginController@logout')->name('logout');
    });

    // Dashboard
    Route::resource('dashboard', 'DashboardController')->only([
        'index'
    ]);

    // Manager
    Route::resource('manager', 'ManagerController');

    // Vendor
    Route::namespace('Vendor')->group(function () {

        // Vendor
        Route::resource('vendor', 'VendorController')->only([
            'index', 'show', 'edit'
        ]);

        Route::prefix('vendor/{vendor}')->name('vendor.')->group(function () {

            Route::resource('menu', 'MenuItemController')->only([
                'index', 'create', 'edit'
            ]);
            Route::get('menu/{menu}', 'MenuItemController@show')->name('menu.show')->where(['menu' => '[0-9]+']);

            Route::prefix('menu')->name('menu.')->group(function () {

                Route::resource('group', 'MenuGroupController')->only([
                    'index', 'create', 'show', 'edit'
                ]);

                Route::resource('option', 'OptionGroupController')->only([
                    'index', 'create', 'edit'
                ]);
                Route::get('option/{option}', 'OptionGroupController@show')->name('option.show')->where(['option' => '[0-9]+']);

                Route::prefix('option')->name('option.')->group(function () {

                    Route::resource('item', 'OptionItemController')->only([
                        'index', 'create', 'show', 'edit'
                    ]);
                });
            });

            Route::resource('coupon', 'CouponController')->only([
                'index', 'create', 'edit'
            ]);
        });
    });

    // User
    Route::resource('user', 'UserController')->only([
        'index', 'show'
    ]);

// Payment
    Route::resource('payment', 'PaymentController')->only([
        'index'
    ]);

    // Article
    Route::resource('article', 'ArticleController')->only([
        'index'
    ]);

    Route::prefix('article')->name('article.')->group(function () {

        // Article - Group
        Route::resource('group', 'ArticleGroupController')->only([
            'index'
        ]);
    });


// Tag

// Support
    Route::namespace('Support')->prefix('support')->name('support.')->group(function () {

        Route::resource('single', 'SingleController')->only([
            'index', 'create'
        ]);

        Route::resource('multiple', 'MultipleController')->only([
            'index', 'create', 'show', 'edit',
        ]);
    });
});