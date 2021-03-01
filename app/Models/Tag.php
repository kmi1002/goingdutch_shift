<?php

namespace App\Models;

use Spatie\Tags\Tag as SpatieTag;
use Spatie\Tags\HasTags;

/**
 * App\Models\Tag
 *
 * @property int $id
 * @property array $name
 * @property array $slug
 * @property string|null $type
 * @property int|null $order_column
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $curations
 * @property-read mixed $translations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $posts
 * @property \Illuminate\Database\Eloquent\Collection|\Spatie\Tags\Tag[] $tags
 * @property-read \App\Models\User $users
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag containing($name, $locale = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag ordered($direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereOrderColumn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag withAllTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Tag withAnyTags($tags, $type = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Tags\Tag withType($type = null)
 * @mixin \Eloquent
 */
class Tag extends SpatieTag
{
    use HasTags;
    protected $fillable = [
        'name',
        'type',
        'user_id'
    ];

    public function posts()
    {
        return $this->morphedByMany('App\Models\Article', 'taggable');
    }

    public function curations()
    {
        return $this->morphedByMany('App\Models\Article', 'taggable');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    public static function mainTags()
    {
        return Tag::where('type', 'category')
            ->where('state_open', 1)
            ->where('state_main', 1)
            ->orderBy('id', 'asc')
            ->get();
    }

    public static function tag($model, $tags, $type, $user_id)
    {
        try {
            if (empty($tags)) {
                return;
            }

            // 특수 문자 치환
            // # : 일반적인 태그
            // + : Youtube 태그
            $tags = strtolower($tags);
            $tags = str_replace('#', '', $tags);
            $tags = str_replace('+', '_', $tags);
            $tags = array_filter(explode(',', $tags));

            // 태그 연결
            $tagWithTypes = [];
            foreach ($tags as $tag) {
                array_push($tagWithTypes, Tag::findOrCreateForUserId(trim($tag), $type, $user_id));
            }
            $model->attachTags($tagWithTypes);

        } catch (\Exception $e) {
            throw new \Exception(\Lang::get('article.alert.upload_tag_error'), 1001001);
        }
    }

    public static function findOrCreateForUserId($values, $type = null, string $user_id = null, string $locale = null)
    {
        $tags = collect($values)->map(function ($value) use ($type, $locale, $user_id) {
            if ($value instanceof Tag) {
                return $value;
            }

            return static::findOrCreateFromStringForUserId($value, $type, $locale, $user_id);
        });

        return is_string($values) ? $tags->first() : $tags;
    }

    public static function findFromLikeName(string $name, $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $tags = static::query()
            ->where("name->{$locale}", 'like', "%{$name}%");

        if ($type) {
            $tags->where('type', $type);
        }

        return $tags->first();
    }

    public static function findFromNames(string $name, $type = null, string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();

        $tags = static::query()
            ->where("name->{$locale}", $name);

        if ($type) {
            $tags->where('type', $type);
        }

        return $tags->get();
    }

    public static function findFromName(string $name, $type = null, string $locale = null)
    {
        $tags = static::findFromNames($name, $type, $locale);

        return $tags->first();
    }

    public static function getTagTypeName($tagType = null)
    {
        if (array_key_exists($tagType, self::$tagTypes)) {
            return self::$tagTypes[$tagType];
        }

        return '';
    }
    protected static function findOrCreateFromStringForUserId(string $name, $type = null, string $locale = null, $user_id): Tag
    {
        $locale = $locale ?? app()->getLocale();

        $tag = static::findFromString($name, $type, $locale);

        if (!$tag) {
            $tag = static::create([
                'name'    => [$locale => $name],
                'type'    => $type,
                'user_id' => $user_id
            ]);
        }

        return $tag;
    }

}