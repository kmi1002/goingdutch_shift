<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Message
 *
 * @property int $id
 * @property string $type
 * @property string $channel
 * @property string $gender
 * @property string $age
 * @property string $name
 * @property string $title
 * @property string $content
 * @property string|null $reserved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereChannel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereReservedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Message whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Message withoutTrashed()
 * @mixin \Eloquent
 */
class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'type',
        'channel',
        'gender',
        'age',
        'name',
        'title',
        'content',
        'reserved_at',
        'user_id',
    ];

    protected $hidden = [

    ];
}
