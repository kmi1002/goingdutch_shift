<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\UserBan
 *
 * @property int $id
 * @property string $reason
 * @property string $expired_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserBan onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserBan whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserBan withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserBan withoutTrashed()
 * @mixin \Eloquent
 */
class UserBan extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reason',
        'expired_at',
        'user_id'
    ];

    protected $hidden = [

    ];
}