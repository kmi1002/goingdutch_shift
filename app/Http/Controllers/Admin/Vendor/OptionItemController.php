<?php
namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\Request;

class OptionItemController extends BaseAdminController
{
    public function index($vendor_id)
    {
        return view('admin.vendor.menu.option.item.index', compact('vendor_id'));
    }

    public function create($vendor_id)
    {
        $mode = 'create';
        return view('admin.vendor.menu.option.item.create', compact('vendor_id', 'mode'));
    }

    public function show($menu_id)
    {
        return view('admin.vendor.menu.option.item.show', compact('menu_id'));
    }

    public function edit($vendor_id, $menu_id)
    {
        $mode = 'edit'; 
        return view('admin.vendor.menu.option.item.create', compact('vendor_id', 'menu_id', 'mode'));
    }
}