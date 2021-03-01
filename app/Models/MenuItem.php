<?php

namespace App\Models;

use App\Helpers\DebugHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MenuItem
 *
 * @property int $id
 * @property string|null $lang
 * @property string $title
 * @property string $content
 * @property float $original_price
 * @property float|null $discount_price
 * @property int|null $discount_percent
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $group_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withoutTrashed()
 * @mixin \Eloquent
 * @property string $code
 * @property string|null $sub_title
 * @property string|null $description
 * @property string|null $caution
 * @property int $recommend
 * @property int $priority
 * @property-read \App\Models\MenuGroup $menuGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionGroup[] $optionGroups
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereSubTitle($value)
 */
class MenuItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'sub_title',
        'description',
        'caution',
        'original_price',
        'discount_price',
        'discount_percent',
        'recommend',
        'active',
        'priority',
        'group_id',
    ];


    protected $hidden = [

    ];

//    protected $casts = [
//        'recommend' => 'boolean',
//        'active' => 'boolean'
//    ];

    public function menuGroup()
    {
        return $this->belongsTo(MenuGroup::class, 'group_id', 'id');
    }

    public function optionGroups()
    {
        return $this->morphToMany(OptionGroup::class, 'option_groupable');
    }


    public static function createItem($request)
    {
        try {
            $item = self::create([
                'code'              => 'menu_' . $request->vendor_id . date('Ymd'),
                'title'             => $request->title,
                'sub_title'         => $request->sub_title,
                'description'       => $request->description,
                'caution'           => $request->caution,
                'original_price'    => $request->original_price,
                'discount_price'    => $request->discount_price,
                'discount_percent'  => $request->discount_percent,
//                'recommend'         => $request->recommend,
//                'active'            => $request->active,
//                'priority'          => $request->priority,
                'group_id'          => $request->group_id,
            ]);

            return $item;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function selectItem($id)
    {
        try {
            $item = self::where('id', $id)->firstOrFail();
            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function updateItem($id, $request)
    {
        try {
            $item = self::where('id', $id)->firstOrFail();

//            $item->code             = $request->code;
            $item->title            = $request->title;
            $item->sub_title        = $request->sub_title;
            $item->description      = $request->description;
            $item->caution          = $request->caution;
            $item->original_price   = $request->original_price;
            $item->discount_price   = $request->discount_price;
            $item->discount_percent = $request->discount_percent;
//            $item->recommend        = $request->recommend;
//            $item->active           = $request->active;
//            $item->priority         = $request->priority;
            $item->group_id         = $request->group_id;
            $item->save();

            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function deleteItem($id)
    {
        try {
            $item = self::where('id', $id)->firstOrFail();

            if ($item) {
                $item->delete();
            }

            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function recoveryItem($id)
    {
        try {
            $item = self::onlyTrashed()->where('id', $id)->firstOrFail();

            if ($item) {
                $item->restore();
            }

            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function showItem($id)
    {
        try {
            $item = self::with( 'optionGroups.childs.optionItems')->where('id', $id)->firstOrFail();
            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public function calcPrice()
    {
        if ($this->discount_price > 0 && $this->discount_percent > 0) {
            return null;
        }

        if ($this->discount_price > 0) {
            if ($this->original_price < $this->discount_price) {
                return null;
            }

            return $this->original_price - $this->discount_price;
        }

        if ($this->discount_percent > 0) {
            $discount_price = $this->original_price * ($this->discount_percent / 100);
            if ($this->original_price < $discount_price) {
                return null;
            }

            return $this->original_price - $discount_price;
        }

        return $this->original_price;
    }

    public static function options($option_group_id)
    {
        $options = OptionGroup::selectItem($option_group_id);

        $retOptions = [];
        foreach ($options as $option) {
            $title = $option->title;

            $value = [];
            foreach($option->optionItems as $item) {
                $value[] = ['id' => $item->id, 'value' => $item->value];
            }

            $retOptions[] = ['title' => $title, 'select' => $value[0]['id'], 'values' => $value];
        }

        return $retOptions;
    }

    public function groupId()
    {
        return $this->optionGroups()->first()->id;
    }

    public static function menuAndOptions($id)
    {
        $menu = self::showItem($id);
        $info = ['id' => $menu->id, 'title' => $menu->title, 'sub_title' => $menu->sub_title, 'price' => $menu->calcPrice()];

        $options = self::options($menu->groupId());

        return [
            'menu' => $menu,
            'items' => [
                'info' => $info,
                'options' => $options
            ]
        ];
    }

    public static function quickCart($id, $count)
    {
        $menu = self::showItem($id);
        $info = ['id' => $menu->id, 'title' => $menu->title, 'sub_title' => $menu->sub_title];

        $options = self::options($menu->groupId());

        $carts = [];
        for ($i = 0; $i < $count; ++$i) {
            $carts[] = [
                'info' => $info,
                'options' => $options
            ];
        }

        return $carts;
    }
}
