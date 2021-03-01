<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class DashboardController extends BaseVendorController
{
    public function index(Request $request)
    {
        return view('vendor.dashboard.index');
//
//        $agent = new Agent();
//        if ($agent->isMobile()) {
//            return view('vendor.mobile.dashboard.index');
//        } else {
//        }
    }
}