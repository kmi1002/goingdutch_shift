<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\VendorMethods;

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
 * @property string|null $kakaoplus_url
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
 * @property string $crn
 * @property string|null $youtube_url
 * @property string|null $instagram_url
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereCrn($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereInstagramUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereKakaoplusUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Vendor whereYoutubeUrl($value)
 */
class Vendor extends Model
{
    use HasRoles;
    use VendorMethods;

    protected $fillable = [
        'company',
        'crn',
        'email',
        'introduce',
        'dpt_code',
        'address',
        'home_url',
        'youtube_url',
        'facebook_url',
        'instagram_url',
        'kakaoplus_url',
        'naver_url',
        'user_id'
    ];

    protected $hidden = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getImageUrl(){
        return asset($this->logo);
    }

    public function sns() {
        if ($this->youtube_url) {
            return $this->youtube_url;
        } else if ($this->facebook_url) {
            return $this->facebook_url;
        } else if ($this->instagram_url) {
            return $this->instagram_url;
        } else if ($this->naver_url) {
            return $this->naver_url;
        } else if ($this->kakaoplus_url) {
            return $this->kakaoplus_url;
        } else {
            return null;
        }
    }
}