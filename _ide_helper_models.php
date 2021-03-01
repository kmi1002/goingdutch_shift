<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
	class ArticleGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property int $id
 * @property string $session_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereSessionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Cart withoutTrashed()
 * @mixin \Eloquent
 * @property string $ip
 * @property string $device
 * @property int $menu_id
 * @property int|null $option_1
 * @property int|null $option_2
 * @property int|null $option_3
 * @property int|null $option_4
 * @property int|null $option_5
 * @property int|null $option_6
 * @property int|null $option_7
 * @property int|null $option_8
 * @property int|null $option_9
 * @property int|null $option_10
 * @property int $vendor_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereOption9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Cart whereVendorId($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Store
 *
 * @property int $id
 * @property string $email
 * @property string|null $password
 * @property string $name
 * @property string $introduce
 * @property string $dpt_code
 * @property string $address
 * @property string|null $home_url
 * @property string|null $naver_url
 * @property string|null $facebook_url
 * @property string|null $kakao_plus
 * @property string|null $copyright
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Vendor onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereCopyright($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereDptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereFacebookUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereHomeUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereIntroduce($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereKakaoPlus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereNaverUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Vendor withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Vendor withoutTrashed()
 * @mixin \Eloquent
 * @property string $company
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereUserId($value)
 */
	class Vendor extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\File
 *
 * @property int $id
 * @property string $type
 * @property string $upload_title
 * @property string $server_title
 * @property string $path
 * @property int $download
 * @property int $size
 * @property int|null $width
 * @property int|null $height
 * @property string $extension
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $users
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereDownload($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereServerTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereUploadTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\File whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\File withoutTrashed()
 * @mixin \Eloquent
 */
	class File extends \Eloquent {}
}

namespace App\Models{
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
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OptionGroup
 *
 * @property int $id
 * @property string $title
 * @property int $active
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int|null $parent_id
 * @property int $vendor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionGroup[] $childs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionGroup[] $menuItem
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionItem[] $optionItems
 * @property-read \App\Models\OptionGroup|null $parent
 * @property-read \App\Models\OptionGroup|null $treeParent
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionGroup whereVendorId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionGroup withoutTrashed()
 * @mixin \Eloquent
 */
	class OptionGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $email
 * @property string|null $password
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string $nick_name
 * @property string|null $birthday
 * @property int|null $gender
 * @property string|null $phone
 * @property string|null $tel
 * @property string|null $fax
 * @property string|null $activation_code
 * @property string|null $activated_at
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property string|null $deleted_reason
 * @property string|null $lang
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Click[] $clicks
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\File[] $files
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Permission[] $permissions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Article[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\Spatie\Permission\Models\Role[] $roles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Share[] $shares
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Tag[] $tags
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserAddress[] $userAddress
 * @property-read \App\Models\UserBan $userBan
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\UserLog[] $userLogs
 * @property-read \App\Models\UserSocial $userSocial
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActivatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereActivationCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirthday($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNickName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Client[] $clients
 * @property-read \Illuminate\Database\Eloquent\Collection|\Laravel\Passport\Token[] $tokens
 * @property-read \App\Models\Vendor $vendor
 */
	class User extends \Eloquent {}
}

namespace App\Models{
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
	class UserBan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MenuGroup
 *
 * @property int $id
 * @property string|null $lang
 * @property string $code
 * @property string $title
 * @property string $content
 * @property string|null $validity
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $category_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuGroup onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereValidity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuGroup withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuGroup withoutTrashed()
 * @mixin \Eloquent
 * @property string|null $description
 * @property int $priority
 * @property int|null $parent_id
 * @property int $vendor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuGroup[] $childs
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\MenuGroup[] $items
 * @property-read \App\Models\MenuGroup|null $parent
 * @property-read \App\Models\MenuGroup|null $treeParent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuGroup whereVendorId($value)
 */
	class MenuGroup extends \Eloquent {}
}

namespace App\Models{
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
	class Like extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $dpt_code
 * @property string $no
 * @property string $name
 * @property string|null $email
 * @property string|null $tel
 * @property string|null $address
 * @property string $table_no
 * @property string $currency
 * @property float $price
 * @property string $ip
 * @property string $device
 * @property string $type
 * @property string $data
 * @property string $status
 * @property string $result
 * @property string|null $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereDevice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereDptCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereOrderTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereResult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTableNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Payment withoutTrashed()
 * @mixin \Eloquent
 * @property string $order_no
 * @property string|null $today_no
 * @property string $item
 * @property int $count
 * @property int $vendor_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PaymentItem[] $paymentItems
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereItem($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereTodayNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Payment whereVendorId($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MessageLog
 *
 * @property int $id
 * @property string $email
 * @property string $success
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $message_id
 * @property int $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageLog onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereMessageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereSuccess($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MessageLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageLog withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MessageLog withoutTrashed()
 * @mixin \Eloquent
 */
	class MessageLog extends \Eloquent {}
}

namespace App\Models{
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
	class UserLog extends \Eloquent {}
}

namespace App\Models{
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
	class Click extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\MenuItem
 *
 * @property int $id
 * @property string|null $lang
 * @property string $title
 * @property string $content
 * @property float $original_price
 * @property float|null $discount_price
 * @property int|null $discount_percent
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $group_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDiscountPercent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDiscountPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereOriginalPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\MenuItem withoutTrashed()
 * @mixin \Eloquent
 * @property string $code
 * @property string|null $sub_title
 * @property string|null $description
 * @property string|null $caution
 * @property int $recommend
 * @property int $priority
 * @property-read \App\Models\MenuGroup $menuGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionGroup[] $optionGroups
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCaution($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereRecommend($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\MenuItem whereSubTitle($value)
 */
	class MenuItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PaymentItem
 *
 * @property int $id
 * @property string $count
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentItem withoutTrashed()
 * @mixin \Eloquent
 * @property string $title
 * @property float $price
 * @property string|null $option_1
 * @property string|null $option_2
 * @property string|null $option_3
 * @property string|null $option_4
 * @property string|null $option_5
 * @property string|null $option_6
 * @property string|null $option_7
 * @property string|null $option_8
 * @property string|null $option_9
 * @property string|null $option_10
 * @property int $payment_id
 * @property int $menu_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereMenuId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption10($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption3($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption4($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption5($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption6($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption7($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption8($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereOption9($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem wherePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\PaymentItem whereTitle($value)
 */
	class PaymentItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserSocial
 *
 * @property int $id
 * @property string $provider
 * @property string $provider_id
 * @property string $access_token
 * @property string|null $refresh_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $user_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSocial onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereAccessToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserSocial whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSocial withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserSocial withoutTrashed()
 * @mixin \Eloquent
 */
	class UserSocial extends \Eloquent {}
}

namespace App\Models{
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
	class Share extends \Eloquent {}
}

namespace App\Models{
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
	class Article extends \Eloquent {}
}

namespace App\Models{
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
	class Message extends \Eloquent {}
}

namespace App\Models{
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
	class Report extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OptionItem
 *
 * @property int $id
 * @property string $value
 * @property int $active
 * @property int $priority
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property int $group_id
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionItem onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\OptionItem whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionItem withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\OptionItem withoutTrashed()
 * @mixin \Eloquent
 */
	class OptionItem extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\UserAddress
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\UserAddress query()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserAddress withoutTrashed()
 * @mixin \Eloquent
 */
	class UserAddress extends \Eloquent {}
}

