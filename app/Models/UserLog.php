<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Browser;
use App\Helpers\IPHelper;

/**
 * App\Models\UserLog
 *
 * @property int $id
 * @property string|null $reason
 * @property string $ip
 * @property string $agent
 * @property string $referer
 * @property string $device
 * @property string $created_at
 * @property int|null $user_id
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereReferer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserLog whereUserId($value)
 * @mixin \Eloquent
 */
class UserLog extends Model
{
    protected $fillable = [
        'reason',
        'ip',
        'agent',
        'referer',
        'device',
        'user_id'
    ];

    protected $hidden = [

    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['created_at'] = $this->freshTimestamp();
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User');
    }

    public static function createLog($user_id, $reason = null)
    {
        try
        {
            static::create([
                'reason'        => $reason,
                'ip'            => IPHelper::realIP(),
                'agent'         => $_SERVER['HTTP_USER_AGENT'] ?? '',
#                'url'           => $_SERVER['REQUEST_URI'] ?? '',
                'referer'       => $_SERVER['HTTP_REFERER'] ?? '',
                'device'        => Browser::platformName(),
                'user_id'       => $user_id,
            ]);
        } catch (\Exception $e) {
        }
    }
}