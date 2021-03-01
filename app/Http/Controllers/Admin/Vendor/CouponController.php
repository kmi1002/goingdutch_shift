<?php
namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\VendorResource;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Vendor;

class CouponController extends BaseAdminController
{
    public function index()
    {
        return view('admin.vendor.coupon.index', compact('vendor_id'));
    }

    public function show($id)
    {
        $vendor = User::selectVendor($id);
        return view('admin.vendor.coupon.show', ['vendor' => $vendor]);
    }

    public function edit($id)
    {
        $vendor = User::selectVendor($id);
        return view('admin.vendor.coupon.edit', ['vendor' => $vendor]);
    }
}