<?php

namespace App\Models;

use App\Helpers\DebugHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OptionGroup
 *
 * @property int $id
 * @property string $title
 * @property int $active
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $parent_id
 * @property int $vendor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionGroup[] $childs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionGroup[] $menuItem
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionItem[] $optionItems
 * @property-read \App\Models\OptionGroup|null $parent
 * @property-read \App\Models\OptionGroup|null $treeParent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereVendorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionGroup withoutTrashed()
 * @mixin \Eloquent
 */
class OptionGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'priority',
        'active',
        'parent_id',
        'vendor_id'
    ];

    protected $hidden = [

    ];

    public function treeParent()
    {
        return $this->belongsTo(OptionGroup::class, 'parent_id', 'id')->with('treeParent');
    }

    public function parent()
    {
        return $this->belongsTo(OptionGroup::class, 'parent_id', 'id');
    }

    public function childs() {
        return $this->hasMany(OptionGroup::class, 'parent_id', 'id');
    }

    public function menuItem()
    {
        return $this->morphedByMany(OptionGroup::class, 'option_groupable');
    }

    public function optionItems()
    {
        return $this->hasMany(OptionItem::class, 'group_id', 'id');
    }

    public static function lists($vendor_id)
    {
        try {
            $items = self::with('childs')
                ->where('vendor_id', $vendor_id)
                ->whereNull('parent_id')
                ->get();

            return $items;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function createItem($request)
    {
        try {
            $item = self::create([
                'title'     => $request->title,
                'priority'  => $request->priority,
                'active'    => $request->active,
                'parent_id' => $request->parent_id,
                'vendor_id' => $request->vendor_id,
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
            $item = self::where('id', $id)->first()->childs()->with('optionItems')->get();
            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function updateItem($id, $request)
    {
        try {
            $item = self::with('parent')->where('id', $id)->firstOrFail();

            $item->title        = $request->title;
            $item->priority     = $request->priority;
            $item->active       = $request->active;
            $item->parent_id    = $request->parent_id;
            $item->vendor_id    = $request->vendor_id;
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
            $item = self::with('parent')->where('id', $id)->firstOrFail();

            if ($item) {
                $item->delete();
            }

            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function recoveryItem($id, $email)
    {
        try {
            $item = self::with('parent')->onlyTrashed()->where('id', $id)->firstOrFail();

            if ($item) {
                $item->restore();
            }

            return $item;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }
}
