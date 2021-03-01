<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

use App\Models\MenuItem;
use App\Models\OptionGroup;
use App\Models\Vendor;


class CartController extends Controller
{
    public function index(Request $request)
    {
        $vendor_id = \Session::get('vendor_id');
        $vendor  = Vendor::selectVendor($vendor_id);

        $carts = Cart::where('session_id', '=', \Session::token())->get();

        $order_items = [];
        $order_price = 0;
        foreach ($carts as $cart) {
            $ret = Cart::selectCart($cart);;
            $order_items[] = $ret;

            $order_price += $ret['info']['price'];
        }

        return view('user.cart.index', [
            'vendor' => $vendor,
            'order_items' => $order_items,
            'order_count' => $carts->count(),
            'order_price' => $order_price,
        ]);
    }
}