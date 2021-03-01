<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\IPHelper;
use Browser;

/**
 * App\Models\Like
 *
 * @property int $id
 * @property string $ip
 * @property string $device
 * @property int|null $type
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Like whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Like withoutTrashed()
 * @mixin \Eloquent
 */
class Like extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'ip',
        'device',
        'type',
        'user_id',
        'reward',
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
        return $this->morphedByMany('App\Models\User', 'clickable');
    }

    public function posts()
    {
        return $this->morphedByMany('App\Models\Article', 'likeable');
    }

    public static function like($model)
    {
        try {
            $user_id = \Auth::check() ? \Auth::user()->id : null;
            $device = Browser::platformName();

            // 보상 없음
            $like = self::create([
                'ip'        => IPHelper::realIP(),
                'device'    => Browser::platformName(),
                'type'      => 0,
                'user_id'   => $user_id,
            ]);

            // $model class에 likes()를 정의함.
            $model->likes()->save($like);

            // 카운트 증가
            $model->like_cnt++;
            $model->save();

            return $like;

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }
}
