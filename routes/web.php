<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// PHP Info
Route::view('/info', 'user.info');


// Root Directory
Route::get('/', function() {
    return redirect('user.main.index');
});


// User
Route::namespace('User')->name('user.')->group(function () {

    // Auth
    Route::namespace('Auth')->prefix('auth')->name('auth.')->group(function () {

        // SNS
        Route::get('oauth/{provider}', 'LoginController@redirectToProvider')->name('social.signin');
        Route::get('oauth/{provider}/callback', 'LoginController@handleProviderCallback')->name('social.callback');

        // Signin
        Route::get('login', 'LoginController@loginForm')->name('login.form');
        Route::post('login', 'LoginController@login')->name('login');
        Route::get('logout', 'LoginController@logout')->name('logout');

        // Signup
        Route::get('register', 'RegisterController@signupForm')->name('register.form');
        Route::post('register', 'RegisterController@signup')->name('register');
        Route::post('withdrawal', 'RegisterController@withdrawal')->name('withdrawal');

        // Signup - confrim
        Route::get('certification', 'CertificationController@index')->name('certification.index');
        Route::get('certification/{token}', 'CertificationController@store')->name('certification.store');
        Route::post('certification/reset', 'CertificationController@reset')->name('certification.reset');
        Route::get('certification/congratulation', 'CertificationController@congratulation')->name('certification.congratulation');

        // Signup - email (check)
        Route::post('checkEmail', 'RegisterController@checkEmail')->name('checkEmail');

        // Password
        Route::get('password/forgot', 'ForgotPasswordController@forgotForm')->name('password.forgot');
        Route::post('password/forgot/email', 'ForgotPasswordController@forgotEmail')->name('password.forgot.email');
        Route::post('password/forgot/reset', 'ForgotPasswordController@reset')->name('password.forgot.reset');
        Route::get('password/forgot/reset/{token}', 'ForgotPasswordController@resetForm')->name('password.forgot.reset.form');

        // Password
        Route::post('password/reset', 'ResetPasswordController@reset')->name('password.reset');
        Route::get('password/reset/{token}', 'ResetPasswordController@resetForm')->name('password.reset.form');

        // Withdrawal
        Route::get('withdrawal', 'WithdrawalController@withdrawalForm')->name('withdrawal.index');
        Route::post('withdrawal/confirm', 'WithdrawalController@confirm')->name('withdrawal.confirm');
    });

    // main
    Route::get('/', 'MainController@index')->name('main.index');

    // menu
    Route::get('{vendor}', 'MenuController@index')->name('menu.index')->where('vendor', '[A-Za-z0-9]+');
    Route::get('{vendor}/{menu}', 'MenuController@show')->name('menu.show')->where(['vendor' => '[A-Za-z0-9]+', 'menu' => '[0-9]+']);

    // cart
    Route::get('{vendor}/cart', 'CartController@index')->name('cart.index');

    // payment
    Route::post('{vendor}/payment/ready', 'PaymentController@ready')->name('payment.ready');
    Route::post('{vendor}/payment/easy_pay', 'PaymentController@easyPayForm')->name('payment.easy_pay.form');
    Route::post('{vendor}/payment/easy_pay', 'PaymentController@easyPay')->name('payment.easy_pay');

    Route::post('{vendor}/payment/card/callback', 'PaymentController@ksnetCallback')->name('payment.card.ksnetCallback');
    Route::post('{vendor}/payment/card/kspay_wh_rcv', 'PaymentController@kspay_wh_rcv')->name('payment.card.kspay_wh_rcv');
    Route::get('{vendor}/payment/invoice/{order_no}', 'PaymentController@invoice')->name('payment.invoice');
});