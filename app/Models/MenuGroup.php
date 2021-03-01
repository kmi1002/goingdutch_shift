<?php

namespace App\Models;

use App\Helpers\TimeHelper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\MenuGroup
 *
 * @property int $id
 * @property string|null $lang
 * @property string $code
 * @property string $title
 * @property string $content
 * @property string|null $validity
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $category_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereValidity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuGroup withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $description
 * @property int $priority
 * @property int|null $parent_id
 * @property int $vendor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuGroup[] $childs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuGroup[] $items
 * @property-read \App\Models\MenuGroup|null $parent
 * @property-read \App\Models\MenuGroup|null $treeParent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereVendorId($value)
 */
class MenuGroup extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'code',
        'title',
        'description',
        'active',
        'priority',
        'parent_id',
        'vendor_id'
    ];

    protected $hidden = [

    ];

    public function treeParent()
    {
        return $this->belongsTo(MenuGroup::class, 'parent_id', 'id')->with('treeParent');
    }

    public function parent()
    {
        return $this->belongsTo(MenuGroup::class, 'parent_id', 'id');
    }

    public function childs() {
        return $this->hasMany(MenuGroup::class, 'parent_id', 'id');
    }

    public function items()
    {
        return $this->hasMany(MenuGroup::class, 'group_id', 'id');
    }

    public function menuItem()
    {
        return $this->hasMany(MenuItem::class, 'group_id', 'id');
    }

    public static function createItem($request)
    {
        try {
            $item = self::create([
                'code'          => $request->code,
                'title'         => $request->title,
                'description'   => $request->description,
                'active'        => $request->active,
                'priority'      => $request->priority,
                'parent_id'     => $request->parent_id,
                'vendor_id'     => $request->vendor_id,
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
            $item = self::with('parent')->where('id', $id)->firstOrFail();

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

            $item->code         = $request->code;
            $item->title        = $request->title;
            $item->description  = $request->description;
            $item->active       = $request->active;
            $item->priority     = $request->priority;
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

    public static function recoveryItem($id)
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
