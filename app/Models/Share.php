<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Helpers\IPHelper;
use Browser;

/**
 * App\Models\Share
 *
 * @property int $id
 * @property string $key
 * @property string $ver
 * @property string $ip
 * @property string $agent
 * @property string $referer
 * @property string $device
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $posts
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereReferer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Share whereVer($value)
 * @mixin \Eloquent
 */
class Share extends Model
{

    protected $fillable = [
        'share_key',
        'ver',
        'ip',
        'agent',
        'referer',
        'device',
        'user_id',
    ];

    protected $hidden = [

    ];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->attributes['created_at'] = $this->freshTimestamp();
    }

    public function posts()
    {
        return $this->morphedByMany('App\Models\Article', 'shareable');
    }

    public static function share($model, $key, $version, $user_id)
    {
        try {
            $share = self::create([
                'share_key'           => $key,
                'ver'           => $version,
                'ip'            => IPHelper::realIP(),
                'agent'         => $_SERVER['HTTP_USER_AGENT'] ?? '',
                'referer'       => $_SERVER['HTTP_REFERER'] ?? '',
                'device'        => Browser::platformName(),
                'user_id'       => $user_id,
            ]);

            // $model class에 shares()를 정의함.
            $model->shares()->save($share);

            // 카운트 증가
            $model->share_cnt++;
            $model->save();

            return $share;

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }
}
