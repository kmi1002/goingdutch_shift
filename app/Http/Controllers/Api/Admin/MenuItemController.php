<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Resources\Admin\MenuItemResource;
use Illuminate\Http\Request;
use App\Models\MenuItem;

class MenuItemController extends BaseApiController
{
    public function index(Request $request, $vendor_id)
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

    public function store(Request $request)
    {
        try {
            $menu = MenuItem::createItem($request);
            if ($menu) {
                return new MenuItemResource($menu);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function show(Request $request, $vendor_id, $menu_id)
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

    public function update(Request $request, $vendor_id, $menu_id)
    {
        try {
            $menu = MenuItem::updateItem($menu_id, $request);
            if ($menu) {
                return new MenuItemResource($menu);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function destroy($vendor_id, $menu_id)
    {
        try {
            $menu = MenuItem::deleteItem($menu_id);
            if ($menu) {
                return new MenuItemResource($menu);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function recommend(Request $request, $vendor_id, $menu_id)
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

    public function active(Request $request, $vendor_id, $menu_id)
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

    public function recovery(Request $request)
    {
        try {
            $id     = $request->id;

            $menu = MenuItem::recoveryItem($id);
            if ($menu) {
                return new MenuItemResource($menu);
            }

            return response()->json(['msg' => '1no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }
}