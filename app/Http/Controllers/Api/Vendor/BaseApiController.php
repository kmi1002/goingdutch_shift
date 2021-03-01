<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:vendor');
        $this->middleware(['role:vendor_administrator|vendor_manager|vendor_operator|vendor_analyst']);
    }
}