<?php
namespace App\Models;

use App\Helpers\DebugHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\ArticleGroup
 *
 * @property int $id
 * @property string $title
 * @property string|null $mobile_title
 * @property string $type
 * @property string|null $platform
 * @property string|null $language
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $category_id
 * @property int|null $parent_id
 * @property-read \App\Models\ArticleCategory $category
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $post
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereLanguage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereMobileTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup wherePlatform($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ArticleGroup withoutTrashed()
 * @mixin \Eloquent
 * @property string $code
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ArticleGroup[] $childs
 * @property-read \App\Models\ArticleGroup|null $parent
 * @property-read \App\Models\ArticleGroup|null $treeParent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ArticleGroup whereCode($value)
 */
class ArticleGroup extends Model
{
    use SoftDeletes;

    protected $table = 'post_groups';

    protected $fillable = [
        'title',
        'mobile_title',
        'code',
        'platform',
        'language',
        'url',
        'parent_id',
        'priority'
    ];

    protected $hidden = [

    ];

    public function treeParent()
    {
        return $this->belongsTo(ArticleGroup::class, 'parent_id', 'id')->with('treeParent');
    }

    public function parent()
    {
        return $this->belongsTo(ArticleGroup::class, 'parent_id', 'id');
    }

    public function childs() {
        return $this->hasMany(ArticleGroup::class, 'parent_id', 'id');//->with('childs');
    }

    public function post()
    {
        return $this->hasMany(Article::class, 'group_id', 'id');
    }

    public static function createGroup($parent_id, $title, $code, $platform, $language)
    {
        try {
            // 헷갈릴 수 있으니 참고!
            // $group       - 현재 그룹 코드
            // $title       - 추가할 이름
            // $code        - 추가할 코드

            // 코드 중복 체크
            if (self::isDuplicateCode($code, $platform, $language)) {
                return null;

//                throw new \Exception('Group Code exists');
            }

            $group = self::create([
                'title'         => $title,
                'mobile_title'  => $title,
                'code'          => $code,
                'platform'      => $platform,
                'language'      => $language,
                'parent_id'     => $parent_id
            ]);

            return $group;

        } catch (\Exception $e) {

        }

        return null;
    }


    public static function selectGroup($id)
    {
        try {
            return self::where('id', $id)->firstOrFail();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function updateGroup($id, $parent_id, $title, $code, $platform, $language)
    {
        try {
            $group = self::where('id', $id)->firstOrFail();

            // 코드 중복 체크
            if ($group->code        != $code ||
                $group->platform    != $platform ||
                $group->language    != $language) {

                if (self::isDuplicateCode($code, $platform, $language)) {
                    return null;
                }
            }
//
////            // 이전 데이터 비교
////            if ($group->title       == $title &&
////                $group->code        == $code &&
////                $group->platform    == $platform &&
////                $group->language    == $language &&
////                $group->parent_id   == $parent_id) {
////                return null;
////            }

            $group->title       = $title;
            $group->code        = $code;
            $group->platform    = $platform;
            $group->language    = $language;
            $group->parent_id   = $parent_id;
            $group->save();

            return $group;

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }

        return null;
    }

    public static function deleteGroup($id)
    {
        try {
            $group = self::where('id', $id)->firstOrFail();

            if ($group) {
                $group->delete();
            }

            return $group;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function groupId($code, $platform, $language)
    {
        try {
            return self::group($code, $platform, $language)->id;
        } catch (\Exception $e) {

        }

        return null;
    }

    public static function group($code, $platform, $language)
    {
        try {
            return self::with('parent')
                ->where(function ($query) use ($code, $platform, $language) {
                    $query->where('code', $code);

                    if (!empty($paltform)) {
                        $query->where('platform', $platform);
                    }

                    if (!empty($language)) {
                        $query->where('language', $language);
                    }
                })
                ->firstOrFail();

        } catch (\Exception $e) {

            dd($e);

        }

        return null;
    }

    // code가 속한 Group ID를 찾고, 사용하고 있는 code의 id를 찾는다.
    public static function groupIds($code, $platform, $language)
    {
        try {
            // code가 속한 Group ID를 찾기
            $group = self::group($code, $platform, $language);

            $tmp = self::where('parent_id', $group->id)->pluck('id');
            if (count($tmp)) {
                return $tmp->push($group->id);
            } else {
                return [$group->id];
            }

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function subGroups($code, $platform, $language)
    {
        try {
            // code가 속한 Group ID를 찾기
            $group = self::group($code, $platform, $language);

            return self::where('parent_id', $group->id)->get();

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function groupRootId($parent_id, $platform = null, $language = null)
    {
        try {
            return self::groupRoot($parent_id, $platform, $language)->id;
        } catch (\Exception $e) {

        }

        return null;
    }

    public static function groupRoot($parent_id, $platform = null, $language = null)
    {
        try {
            try {
                $group = self::with('treeParent')
                    ->where(function ($query) use ($parent_id, $platform, $language) {
                        if (!empty($parent_id)) {
                            $query->where('id', $parent_id);
                        }

                        if (!empty($paltform)) {
                            $query->where('platform', $platform);
                        }

                        if (!empty($language)) {
                            $query->where('language', $language);
                        }
                    })
                    ->first();

                return $group->accendings()->last();

            } catch (\Exception $e) {

            }

            return null;

        } catch (\Exception $e) {

        }

        return null;
    }

    public static function isDuplicateCode($code, $platform, $language)
    {
        $groups = self::where('code', $code)
            ->where('platform', $platform)
            ->where('language', $language)
            ->get();

        return count($groups) > 0;
    }


    public function accendings()
    {
        $accendings = collect();

        $target = $this;

        $accendings->push($target);

        while ($target->treeParent) {

            $accendings->push($target->treeParent);

            if ($target->treeParent) {
                $target = $target->treeParent;
            }
        }

        return $accendings;
    }
}