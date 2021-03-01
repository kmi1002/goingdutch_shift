<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\OptionItem
 *
 * @property int $id
 * @property string $value
 * @property int $active
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $group_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionItem withoutTrashed()
 * @mixin \Eloquent
 */
class OptionItem extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'value',
        'priority',
        'active',
        'group_id'
    ];

    protected $hidden = [

    ];


    public function optionGroup()
    {
        return $this->belongsTo(OptionGroup::class)->first();
    }

    public static function createItem($request)
    {
        try {
            $item = self::create([
                'value'     => $request->value,
                'priority'  => $request->priority,
                'active'    => $request->active,
                'group_id'  => $request->group_id,
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

            $item->value    = $request->value;
            $item->priority = $request->priority;
            $item->active   = $request->active;
            $item->group_id = $request->group_id;
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
