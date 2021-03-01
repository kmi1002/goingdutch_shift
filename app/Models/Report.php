<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Helpers\IPHelper;

/**
 * App\Models\Report
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $answer
 * @property string $ip
 * @property int $state
 * @property string|null $answerd_at
 * @property int $user_id
 * @property int|null $answer_id
 * @property string|null $created_at
 * @property string|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $posts
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereAnswer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereAnswerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereAnswerdAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Report whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Report withoutTrashed()
 * @mixin \Eloquent
 */
class Report extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'answer',
        'ip',
        'state',
        'answerd_at',
        'user_id',
        'answer_id',
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
        return $this->morphedByMany('App\Models\Article', 'reportable');
    }

    public static function report($model, $title, $content)
    {
        try {
            if (!\Auth::check()) {
                throw new \Exception('Unauthenticated', 401);
            }

            $report = static::create([
                'title'     => $title,
                'content'   => $content,
                'ip'        => IPHelper::realIP(),
                'state'     => 0,
                'user_id'   => \Auth::user()->id,
            ]);

            // $model class에 reports()를 정의함.
            $model->reports()->save($report);

            // 카운트 증가
            $model->report_cnt++;
            $model->save();

            return $report;

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }


    public static function answer($id, $answer)
    {
        try {
            if (!\Auth::check()) {
                throw new \Exception('Unauthenticated', 401);
            }

            $report = static::findOrfail($id);
            $report->answer = $answer;
            $report->state = 1;
            $report->answer_id = \Auth::check() ? \Auth::user()->id : null;
            $report->answerd_at = \Carbon\Carbon::now()->toDateTimeString();

        } catch (\Exception $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
        }

        return response($msg, $code);
    }
}
