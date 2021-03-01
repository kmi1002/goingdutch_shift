<?php

namespace App\Models;

use App\Helpers\TimeHelper;
use App\Models\CouponItem;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    protected $fillable = [
        'item_id',
        'payment_id',
        'used',
        'expired_at',
    ];

    protected $hidden = [

    ];

    public static function createItem($row)
    {
        try {
            $target = CouponItem::selectItemType($row['vendor_id'], $row['type']);

            $item = static::create([
                'item_id'       => $target->id,
                'payment_id'    => $row['payment_id'],
                'expired_at'    => TimeHelper::addDay($target->validity)->format('Y-m-d') ?? null,
            ]);

            return ['item' => $target, 'history' => $item];

        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                throw new Exception('이미 발급된 쿠폰입니다');
            }

            throw $e;
        }

        return null;
    }

    public static function selectItem($id)
    {
        try {
            return static::where('id', $id)->firstOrFail();
        } catch (\Exception $e) {
            throw $e;
        }

        return null;
    }

    public static function updateItem($id, $request)
    {
        try {
            $item = static::selectItem($id);

            $item->used = $request->used;
            $item->save();

            return $item;

        } catch (\Exception $e) {
            throw $e;
        }

        return null;
    }

    public static function deleteItem($id)
    {
        try {
            $item = static::selectItem($id);
            if ($item) {
                $item->delete();
            }

            return $item;

        } catch (\Exception $e) {
            throw $e;
        }

        return null;
    }
}
