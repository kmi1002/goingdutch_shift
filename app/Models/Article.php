<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use \App\Helpers\TimeHelper;
use Spatie\Tags\HasTags;
use App\Traits\UserMethods;

use App\Helpers\SlugHelper;


use Browser;

/**
 * App\Models\Article
 *
 * @property int $id
 * @property string|null $title
 * @property string $content
 * @property string|null $link
 * @property string|null $nick_name
 * @property string|null $email
 * @property string|null $homepage
 * @property string|null $tel
 * @property string|null $password
 * @property int|null $html
 * @property int|null $secret
 * @property int|null $notice
 * @property int|null $hide_comment
 * @property int|null $recevied_email
 * @property int|null $click_cnt
 * @property int|null $like_cnt
 * @property int|null $dislike_cnt
 * @property int|null $comment_cnt
 * @property int|null $share_cnt
 * @property int|null $report_cnt
 * @property string $ip
 * @property string $device
 * @property string|null $slug
 * @property string|null $published_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $group_id
 * @property int $user_id
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ArticleGroup[] $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Click[] $clicks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read \App\Models\ArticleGroup $group
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read \App\Models\Article $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Report[] $reports
 * @property \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Share[] $shares
 * @property-read \App\Models\User $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereClickCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCommentCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereDislikeCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereHideComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereHtml($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereLikeCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereNickName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereNotice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article wherePublishedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereReceviedEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereReportCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereShareCnt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Article withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Article withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\ArticleGroup $groups
 */
class Article extends Model
{
    use HasTags;
    use UserMethods;
    use SoftDeletes;

    protected $table = 'posts';


    protected $fillable = [
        'title',
        'content',
        'link',
        'nick_name',
        'email',
        'homepage',
        'tel',
        'password',
        'html',
        'secret',
        'notice',
        'hide_comment',
        'recevied_email',
        'krc',
        'click_cnt',
        'like_cnt',
        'dislike_cnt',
        'comment_cnt',
        'share_cnt',
        'share_author_cnt',
        'report_cnt',
        'ip',
        'device',
        'group_id',
        'user_id',
        'parent_id',
        'published_at',
        'slug'
    ];

    protected $hidden = [
        'password',
    ];

    public function groups()
    {
        return $this->belongsTo('App\Models\ArticleGroup', 'group_id', 'id');
    }

    public function files()
    {
        return $this->morphToMany('App\Models\File', 'fileable');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public function timeAgo()
    {
        return TimeHelper::timeAgo(\Carbon\Carbon::parse($this->published_at, 'Asia/Seoul')->timestamp);
    }

    public function tags()
    {
        return $this->morphToMany('App\Models\Tag', 'taggable');
    }

    public function clicks()
    {
        return $this->morphToMany('App\Models\Click', 'clickable');
    }

    public function likes()
    {
        return $this->morphToMany('App\Models\Like', 'likeable');
    }

    public function shares()
    {
        return $this->morphToMany('App\Models\Share', 'shareable');
    }

    public function reports()
    {
        return $this->morphToMany('App\Models\Report', 'reportable');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Article', 'id', 'parent_id');
    }


    public static function tagNames($tags)
    {
        $tagNames = [];
        foreach ($tags as $tag) {
            array_push($tagNames, $tag->name);
        }

        return $tagNames; //implode(',', $tagNames);
    }

    public function url()
    {
        return \Carbon\Carbon::parse($this->published_at)->format('Y/mobile/d') . '/' . $this->slug;
    }

    public function nickName()
    {
        return $this->nick_name ?? $this->users->nick_name;
    }

    public function removeHtmlTitle()
    {
        return $this->removeHtml($this->title, 200);
    }

    public function removeHtmlContent()
    {
        return $this->removeHtml($this->content, 100);
    }

    public function removeHtml($html, $length)
    {
        $html = html_entity_decode($html);
        $html = strip_tags($html, ' \t\n\r\0\x0B\xC2\xA0');

        return mb_substr($html,0, $length, 'utf-8');
    }

    public function shareTag()
    {
        $tagNames = [];
        foreach ($this->tags as $tag) {
            array_push($tagNames, $tag->name);
        }

        return implode(',', $tagNames);
    }

    public function updateSlug()
    {
        // slug를 적용하기 위해서 제목이 없는 경우, 임시 제목을 생성해준다.
        if ($this->title) {
            $slugTitle = $this->title;
        } else {
            $slugTitle = substr(htmlspecialchars((strip_tags($this->content)), ENT_QUOTES), 0, 100);
        }

        // 글 생성 - slug
        $this->slug = SlugHelper::slug($slugTitle . ' ' . $this->id );
        $this->save();
    }

    public static function comment($model)
    {
        try {
            $user_id = \Auth::check() ? \Auth::user()->id : null;
            $device = Browser::platformName();

            $model->comment_cnt++;
            $model->save();

            return;

        } catch (\Exception $e) {
            $code       = $e->getCode();
            $msg        = $e->getMessage();
        }

        return response($msg, $code);
    }

}
