<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;

class BaseVendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
        $this->middleware(['role:vendor_administrator|vendor_manager|vendor_operator|vendor_analyst']);
    }
}