<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Vendor\BaseVendorController;
use App\Models\User;
use App\Models\Vendor;

class ManagerController extends BaseVendorController
{
    var $roles = ['vendor_administrator', 'vendor_manager', 'vendor_operator', 'vendor_analyst'];

    public function index()
    {
        $user_id = \Auth::guard('vendor')->user()->id;
        $vendor = Vendor::with('user')
            ->whereHas('user', function ($query) use ($user_id) {
                $query->where('id', $user_id);
            })->first();

        $roles = User::rolesCount($this->roles);

        return view('vendor.manager.index', ['roles' => $roles, 'vendor' => $vendor]);
    }
}