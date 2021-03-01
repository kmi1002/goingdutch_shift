<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\IPHelper;
use Browser;


/**
 * App\Models\Cart
 *
 * @property int $id
 * @property string $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart withoutTrashed()
 * @mixin \Eloquent
 * @property string $ip
 * @property string $device
 * @property int $menu_id
 * @property int|null $option_1
 * @property int|null $option_2
 * @property int|null $option_3
 * @property int|null $option_4
 * @property int|null $option_5
 * @property int|null $option_6
 * @property int|null $option_7
 * @property int|null $option_8
 * @property int|null $option_9
 * @property int|null $option_10
 * @property int $vendor_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereVendorId($value)
 */
class Cart extends Model
{
    protected $fillable = [
        'session_id',
        'ip',
        'device',
        'menu_id',
        'option_1',
        'option_2',
        'option_3',
        'option_4',
        'option_5',
        'option_6',
        'option_7',
        'option_8',
        'option_9',
        'option_10',
        'vendor_id',
        'user_id',
    ];

    protected $hidden = [

    ];

    public static function createCart($request)
    {
        try {
            $user_id    = \Auth::check() ? \Auth::user()->id : null;
            $vendor_id  = $request->vendor_id;
            $items      = json_decode($request->items);

            $carts = [];
            foreach ($items as $item) {

                $ret_option = array_fill(0, 10, null);
                foreach ($item->options as $index => $option) {
                    $ret_option[$index] = $option->select;
                }

                $carts[] = self::create([
                    'session_id'    => \Session::token(),
                    'ip'            => IPHelper::realIP(),
                    'device'        => Browser::platformName(),
                    'menu_id'       => $item->info->id,
                    'option_1'      => $ret_option[0],
                    'option_2'      => $ret_option[1],
                    'option_3'      => $ret_option[2],
                    'option_4'      => $ret_option[3],
                    'option_5'      => $ret_option[4],
                    'option_6'      => $ret_option[5],
                    'option_7'      => $ret_option[6],
                    'option_8'      => $ret_option[7],
                    'option_9'      => $ret_option[8],
                    'option_10'     => $ret_option[9],
                    'vendor_id'     => $vendor_id,
                    'user_id'       => $user_id,
                ]);
            }

            return $carts;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function deleteCart($id)
    {
        try {
            $cart = Cart::where('id', $id)->firstOrFail();

            if ($cart) {
                $cart->delete();
            }

            return $cart;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function deleteCartAll($ids)
    {
        try {
            $cart = Cart::whereIn('id', $ids)->delete();

            return $cart;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function selectCart($cart)
    {
        $menu_id = $cart->menu_id;

        $menu = MenuItem::showItem($menu_id);

        $option_group_id = $menu->optionGroups()->first()->id;
        $options = OptionGroup::selectItem($option_group_id);

        $retOptions = [];
        $tmpOptions = [];
        foreach ($options as $index => $option) {
            $title = $option->title;

            switch ($index) {
                case 0: $select = $cart->option_1;    break;
                case 1: $select = $cart->option_2;    break;
                case 2: $select = $cart->option_3;    break;
                case 3: $select = $cart->option_4;    break;
                case 4: $select = $cart->option_5;    break;
                case 5: $select = $cart->option_6;    break;
                case 6: $select = $cart->option_7;    break;
                case 7: $select = $cart->option_8;    break;
                case 8: $select = $cart->option_9;    break;
                case 9: $select = $cart->option_10;    break;
                default: $select = 1; break;
            }

            $value = [];
            foreach($option->optionItems as $item) {
                $value[] = ['id' => $item->id, 'value' => $item->value];

                if ($select == $item->id) {
                    $tmpOptions[] = $item->value;
                }
            }

            $retOptions[] = ['title' => $title, 'select' => $select, 'values' => $value];
        }

        $info = ['id' => $menu->id, 'title' => $menu->title, 'sub_title' => $menu->sub_title, 'price' => $menu->calcPrice(), 'options' => implode(' / ', $tmpOptions)];

        return [
            'id'    => $cart->id,
            'info' => $info,
            'options' => $retOptions,
        ];
    }


}
