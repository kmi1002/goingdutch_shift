<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Helpers\TimeHelper;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

use Spatie\Permission\Traits\HasRoles;
use App\Traits\UserMethods;
use App\Traits\ManagerMethods;
use App\Traits\VendorMethods;

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
class User extends Authenticatable
{
    use HasApiTokens;
    use Notifiable;
    use HasRoles;
    use UserMethods;
    use ManagerMethods;
    use VendorMethods;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'password',
        'nick_name',
        'activation_code',
        'activated_at',
        'deleted_reason',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function vendor()
    {
        return $this->hasOne(Vendor::class);
    }

    public function userSocial()
    {
        return $this->hasOne('App\Models\UserSocial');
    }

    public function userLogs()
    {
        return $this->hasMany('App\Models\UserLog');
    }

    public function userAddress()
    {
        return $this->hasMany('App\Models\UserAddress');
    }

    public function userBan()
    {
        return $this->hasOne('App\Models\UserBan');
    }

    public function tags()
    {
        return $this->hasMany('App\Models\Tag');
    }

    public function files()
    {
        return $this->morphToMany('App\Models\File', 'fileable');
    }

    public function likes()
    {
        return $this->morphToMany('App\Models\Like', 'likeable');
    }

    public function posts()
    {
        return $this->hasMany('App\Models\Article', 'user_id', 'id');
    }

    public function shares()
    {
        return $this->hasMany('App\Models\Share', 'user_id', 'id');
    }

    public function clicks()
    {
        return $this->morphToMany('App\Models\Click', 'clickable');
    }

    public function roles()
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            'model_id',
            'role_id'
        );
    }

    static public function createUser($data)
    {
        $user       = null;
        $name       = $data['name'];
        $email      = $data['email'];
        $pass       = $data['password'] ?? null;
        $provider   = $data['provider'] ?? null;

        try {
            if (isset($provider)) {
                $user = User::create([
                    'nick_name'         => $name,
                    'email'             => $email,
                    'password'          => bcrypt($pass),
                    'activated_at'      => \Carbon\Carbon::now()->toDateTimeString()
                ]);

                UserSocial::createUserSocial($user, $provider, \Session::get('socialiteUser'));

                session()->forget('provider');
                session()->forget('socialiteUser');
            } else {
                $user = User::create([
                    'nick_name'         => $name,
                    'email'             => $email,
                    'password'          => bcrypt($pass),
                    'activation_code'   => str_random(64)
                ]);
            }

            // 유저 권한
            $user->assignRole('user');

        } catch (\Exception $e) {
            logger()->error($e);
        }

        return $user;
    }
}
