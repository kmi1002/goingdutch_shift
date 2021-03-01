<?php

namespace App\Http\Controllers\Vendor;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Http\Request;

class InfoController extends BaseVendorController
{
    public function show()
    {
        $user = \Auth::guard('vendor')->user();
        $vendor = User::selectVendor($user->vendor->id);
        return view('vendor.info.show', ['vendor' => $vendor]);
    }

    public function edit($id)
    {
        $user = \Auth::guard('vendor')->user();
        $vendor = User::selectVendor($user->vendor->id);
        return view('vendor.info.edit', ['vendor' => $vendor]);
    }
}