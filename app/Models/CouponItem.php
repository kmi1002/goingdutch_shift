<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CouponItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'title',
        'description',
        'price',
        'percent',
        'validity',
        'vendor_id',
    ];

    protected $hidden = [

    ];

    public static function createItem($row)
    {
        try {
            if ($row['price'] > 0 && $row['percent'] > 0) {
                throw new Exception('할인 금액과 할인 퍼센트는 동시에 적용할 수 없습니다.');
            }

            return static::create([
                'type'          => $row['type'],
                'title'         => $row['title'],
                'description'   => $row['description'],
                'price'         => $row['price'],
                'percent'       => $row['percent'],
                'validity'      => $row['validity'],
                'vendor_id'     => $row['vendor_id'],
            ]);

        } catch (\Exception $e) {
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

    public static function selectItemType($vendor_id, $type)
    {
        try {
            return static::where('vendor_id', $vendor_id)
                ->where('type', $type)
                ->firstOrFail();
        } catch (\Exception $e) {
            throw $e;
        }

        return null;
    }

    public static function updateItem($id, $request)
    {
        try {
            $item = static::selectItem($id);

            $item->type         = $request->type;
            $item->title        = $request->title;
            $item->description  = $request->description;
            $item->validity     = $request->validity;
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

    public function discount()
    {
        if ($this->price > 0) {
            return number_format($this->price) . '원 할인';
        }

        if ($this->percent > 0) {
            return $this->price . '% 할인';
        }
    }
}
