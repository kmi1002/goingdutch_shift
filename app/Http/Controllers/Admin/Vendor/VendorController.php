<?php
namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;
use App\Http\Resources\Admin\VendorResource;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Vendor;

class VendorController extends BaseAdminController
{
    public function index()
    {
        return view('admin.vendor.index');
    }

    public function show($id)
    {
        $vendor = User::selectVendor($id);
        return view('admin.vendor.show', ['vendor' => $vendor]);
    }

    public function edit($id)
    {
        $vendor = User::selectVendor($id);
        return view('admin.vendor.edit', ['vendor' => $vendor]);
    }
}