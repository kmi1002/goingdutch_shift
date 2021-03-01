<?php

namespace App\Http\Controllers\Api\Vendor;

use App\Http\Controllers\Api\Vendor\BaseApiController;
use App\Http\Resources\Admin\MenuItemResource;
use Illuminate\Http\Request;

use App\Models\MenuItem;

class MenuItemController extends BaseApiController
{
    public function index(Request $request)
    {
        dd('a');

        try {
            $page       = $request->page;
            $per_page   = $request->per_page;

            $vendors = MenuItem::with('menuGroups')
                ->withTrashed()
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
                ->orderByDesc('id')
                ->paginate($per_page, ['*'], 'page', $page);

            return MenuItemResource::collection($vendors);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function store()
    {
    }

    public function show($id)
    {
    }

    public function update(Request $request, $id)
    {

    }

    public function destroy($id)
    {
    }

    public function menus(Request $request, $vendor_id)
    {
        try {
            $page       = $request->page;
            $per_page   = $request->per_page;

            $menus = MenuItem::with('menuGroup')
                ->withTrashed()
                ->whereHas('menuGroup', function ($query) use ($request, $vendor_id) {
                    $query->where('vendor_id', $vendor_id);
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
                ->orderByDesc('id')
                ->paginate($per_page, ['*'], 'page', $page);

            return MenuItemResource::collection($menus);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function menu(Request $request, $vendor_id, $menu_id)
    {
        try {
            $menu = MenuItem::with('menuGroup')
                ->withTrashed()
                ->whereHas('menuGroup', function ($query) use ($request, $vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                })
                ->where('id', $menu_id)
                ->firstOrFail();

            return new MenuItemResource($menu);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function menuRecommend(Request $request, $vendor_id, $menu_id)
    {
        try {
            $recommend =  $request->recommend == "true" ? 1 : 0;

            $menu = MenuItem::with('menuGroup')
                ->withTrashed()
                ->whereHas('menuGroup', function ($query) use ($request, $vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                })
                ->where('id', $menu_id)
                ->firstOrFail();

            if ($menu) {
                $menu->recommend = $recommend;
                $menu->save();
            }

            return new MenuItemResource($menu);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }


    public function menuActive(Request $request, $vendor_id, $menu_id)
    {
        try {
            $active =  $request->active == "true" ? 1 : 0;

            $menu = MenuItem::with('menuGroup')
                ->withTrashed()
                ->whereHas('menuGroup', function ($query) use ($request, $vendor_id) {
                    $query->where('vendor_id', $vendor_id);
                })
                ->where('id', $menu_id)
                ->firstOrFail();

            if ($menu) {
                $menu->active = $active;
                $menu->save();
            }

            return new MenuItemResource($menu);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }
}