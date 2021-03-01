<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\OptionGroup;
use Illuminate\Http\Request;
use App\Models\MenuGroup;
use App\Models\MenuItem;
use App\Models\User;
use App\Models\Vendor;

class MenuController extends Controller
{
    public function index(Request $request, $vendor_id)
    {
        $vendor = User::selectVendor($vendor_id);
//        dd($vendor);

        $groups = MenuGroup::with('menuItem')
            ->withTrashed()
            ->whereHas('menuItem', function ($query) use ($request, $vendor_id) {
                $query->where('active', 1);
                $query->orderByDesc('priority');
            })
            ->where(function ($query) use ($request) {
                if (!empty($request->search_text)) {
                    $query->where('title', 'like', "%{$request->search_text}%");
                }

                if (!empty($request->start_date)) {
                    $query->whereDate('created_at', '>=', $request->start_date);
                }

                if (!empty($request->end_date)) {
                    $query->whereDate('created_at', '<=', $request->end_date);
                }
            })
            ->where('vendor_id', $vendor_id)
            ->where('active', 1)
            ->orderByDesc('priority')
            ->get();

//        dd($groups);

        return view('user.menu.list', ['vendor' => $vendor, 'groups' => $groups]);
    }

    public function show(Request $request, $vendor_id, $menu_id)
    {
        try {
            $menu = MenuItem::menuAndOptions($menu_id);
            $vendor = Vendor::selectVendor($vendor_id);

//            dd($menu['menu']->optionGroups->count());


            return view('user.menu.item', ['vendor' => $vendor, 'menu' => $menu]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}