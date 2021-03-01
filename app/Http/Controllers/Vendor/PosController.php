<?php

namespace App\Http\Controllers\Vendor;

use Illuminate\Http\Request;

class PosController extends BaseVendorController
{
    public function prepare()
    {
        return view('vendor.pos.index', ['vendor_id' => 10, 'type' => 'ready']);
    }

    public function approve()
    {
        return view('vendor.pos.index', ['vendor_id' => 10, 'type' => 'approve']);
    }

    public function completed()
    {
        return view('vendor.pos.index', ['vendor_id' => 10, 'type' => 'completed']);
    }
}