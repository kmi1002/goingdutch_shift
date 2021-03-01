<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\IPHelper;
use Browser;

/**
 * App\Models\Click
 *
 * @property int $id
 * @property string $ip
 * @property string $device
 * @property int|null $user_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Click[] $users
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Click whereUserId($value)
 * @mixin \Eloquent
 */
class Click extends Model
{
    protected $fillable = [
        'ip',
        'device',
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

    public function posts()
    {
        return $this->morphedByMany('App\Models\Article', 'clickable');
    }

    public function users()
    {
        return $this->morphedByMany('App\Models\Click', 'clickable');
    }

    public static function click($model)
    {
        try {
            $click_user_id = \Auth::check() ? \Auth::user()->id : null;
            $ip = IPHelper::realIP();
            $device = Browser::platformName();

            $click = self::create([
                'ip'            => $ip,
                'device'        => $device,
                'user_id'       => $click_user_id
            ]);

            // $model class에 clicks()를 정의함.
            $model->clicks()->save($click);

            $model->click_cnt++; // 카운트 증가
            $model->save();

            return $click;

        } catch (\Exception $e) {
            $code       = $e->getCode();
            $msg        = $e->getMessage();
        }

        return response($msg, $code);
    }
}
