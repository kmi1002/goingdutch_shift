<?php

namespace App\Http\Controllers\Api\User\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Frontend\v1\CartResource;
use App\Models\Cart;
use App\Models\MenuItem;
use App\Models\Payment;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        try {
            $carts = Cart::createCart($request);
//            if ($carts) {
//                return CartResource::collection($carts);
//            }

            return response()->json(0, 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }

    public function destroy($id)
    {
        try {
            $cart = Cart::deleteCart($id);
            if ($cart) {
                return response()->json(['msg' => 'ok'], 200);
            }

            return response()->json(['msg' => 'no content'], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function destroyAll(Request $request)
    {
        try {

            $ids = $request->ids;
            $cart = Cart::deleteCartAll($ids);
            if ($cart) {
                return response()->json(['msg' => 'ok'], 200);
            }

            return response()->json(['msg' => $cart], 202);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }

    public function quick(Request $request)
    {
        try {
            $count = $request->order_count;
            $menu_id = $request->menu_id;
            $items = MenuItem::quickCart($menu_id, $count);

            $request->items = json_encode($items);
            $carts = Cart::createCart($request);

            return response()->json($carts, 200);

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response()->json(['code' => $code, 'msg' => $msg], $code);
    }
}