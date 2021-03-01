<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BaseAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware(['role:administrator|manager|operator|analyst']);


        // https://stackoverflow.com/questions/41542802/laravel-cant-get-session-in-controller-constructor
        $this->middleware(function ($request, $next) {

            if (\Request::is('admin/vendor/*')) {
                if (\Route::currentRouteName() == 'admin.vendor.show') {
                    session()->put('vendor_id', last(request()->segments()));
                }
            } else {
                session()->forget('vendor_id');
            }

            return $next($request);
        });
    }
}