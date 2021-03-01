<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use bcrypt;
use Exception;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\SoftDeletes;


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
class UserSocial extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'provider',
        'provider_id',
    ];

    protected $hidden = [

    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User')->first();
    }

    public static function getUserFromSociliteUser($provider, $socialiteUser)
    {
        $user = User::where('email', (new UserSocial)->getEmailFromSociliteUser($provider, $socialiteUser))->first();

        if (!!$user->userSocial()->first() && $user->userSocial()->first()->provider == $provider) {
            return $user;
        }

        return null;
    }

    public static function createUserSocial(User $user, string $provider, $socialiteUser)
    {
        $userSocial = new UserSocial;

        $userSocial->user_id       = $user->id;
        $userSocial->provider      = $provider;
        $userSocial->provider_id   = $socialiteUser->getId();
        $userSocial->access_token  = $socialiteUser->token;
        $userSocial->refresh_token = $socialiteUser->refreshToken;
        $userSocial->save();

        return $userSocial;
    }

    /**
     *
     * @param  string    $provider      Social auth provider
     * @param  object    $socialiteUser Socialite user object
     * @param  string    $email         email 오류 시
     * @return App\User  $user
     */
    public static function firstOrCreateFromSociliteUser($provider, $socialiteUser, $email = null)
    {
        $user       = null;
        $userSocial = new UserSocial;
        if (empty($email)) {
            $email = $userSocial->getEmailFromSociliteUser($provider, $socialiteUser);
        }

        if (is_null($user = User::where('email', $email)->first())) {
            Log::notice('social 에 대한 비밀번호 설정 이 필요함'); // 1001001
            $created_at = \Carbon\Carbon::now(config('app.timezone'));
            $name       = $userSocial->getNameFromSociliteUser($provider, $socialiteUser);
            $nickname   = $userSocial->getNicknameFromSociliteUser($provider, $socialiteUser);
            $photo_url  = $userSocial->getPhotoFromSociliteUser($provider, $socialiteUser);

            $user             = new User;
            $user->password   = bcrypt("{$email}{$created_at}");
            $user->email      = $email;
            $user->name       = $name ?? ($nickname ?? '');
            $user->created_at = $created_at;
            $user->photo_url  = !!($photo_url) ? $photo_url : null;

            // $user->setDefaultTeam();
            $user->save();

            $userSocial->user_id       = $user->id;
            $userSocial->provider      = $provider;
            $userSocial->provider_id   = $socialiteUser->getId();
            $userSocial->access_token  = $socialiteUser->token;
            $userSocial->refresh_token = $socialiteUser->refreshToken;
            $userSocial->save();

            // event(new UserRegistered($user));

            // 가입 event
        } else {
            $userSocial = $user->getUserSocial();

            if (empty($userSocial)) { // 소셜 로그인인지 아닌지 확인
                throw new Exception('소셜 로그인 대상자가 아닙니다.', 1001001);
            }

            if ($userSocial->provider !== $provider) {
                Log::notice('UserSocial@firstOrCreateFromSociliteUser 앱연결 이 자동으로 되기 때는에 다른 provider 에서는 해제 해야됨');
                throw new Exception("소셜 로그인을 등록된 곳은 {$provider} 가 아니라 {$userSocial->provider} 입니다.", 1001002);
            } elseif ($userSocial->provider_id != $socialiteUser->getId()) {
                Log::warning('UserSocial@firstOrCreateFromSociliteUser 소셜 로그인 provider 는 같으나 식별코드-id 가 다름');
                throw new Exception('소셜 로그인 인증에 문제가 생겼습니다.', 1001003);
            }
            $userSocial->setTokens($socialiteUser->token, $socialiteUser->refreshToken);
            // event(new UserLogin($user));
        }

        return $user;
    }

    /**
     * @param  string $access_token
     * @param  string $refresh_token
     * @return void
     */
    public function setTokens($access_token = '', $refresh_token = '')
    {
        if (!empty($access_token)) {
            if ($this->access_token != $access_token) {
                $this->access_token = $access_token;
                $this->updated_at   = \Carbon\Carbon::now(config('app.timezone'));
            }
        }
        if (!empty($refresh_token)) {
            if ($this->refresh_token != $refresh_token) {
                $this->refresh_token = $refresh_token;
                $this->updated_at    = \Carbon\Carbon::now(config('app.timezone'));
            }
        }
        $this->save();
    }


    public function isSocialUser($provider, $socialiteUser)
    {
        if ($provider && $socialiteUser) {
            return true;
        }

        return false;
    }

    /**
     * @param  string $provider      Social auth provider
     * @param  object $socialiteUser Socialite user object
     * @return string $email
     */
    public function getGenderFromSociliteUser($provider, $socialiteUser)
    {
        $genderFlag = [
            'male'   => '',
            'female' => '',
        ];
        $gender = '';

        try {
            if ($provider == 'kakao') {
            } elseif ($provider == 'naver') {
                $genderFlag['male']   = 'M';
                $genderFlag['female'] = 'F';
                $gender               = $socialiteUser->user['gender'] ?? '';
            } elseif ($provider == 'facebook') {
                $genderFlag['male']   = 'male';
                $genderFlag['female'] = 'female';
                $gender               = $socialiteUser->user['gender'] ?? '';
            }
        } catch (Exception $e) {
            log::error([
                'locate'   => 'App\Models\UserSocial@getEmailFromSociliteUser',
                'provider' => $provider,
            ]);
            log::error($e);
        }

        if (!!($gender)) {
            switch ($gender) {
                case $genderFlag['male']:
                    return 'male';
                    break;
                case $genderFlag['female']:
                    return 'female';
                    break;
            }
        }

        return '';
    }

    /**
     * @param  string $provider      Social auth provider
     * @param  object $socialiteUser Socialite user object
     * @return string $email
     */
    public function getEmailFromSociliteUser($provider, $socialiteUser)
    {
        $email = null;

        $email = $socialiteUser->email;

        try {
            if (empty($email)) {
                if ($provider == 'kakao') {
                    $email = $socialiteUser->user['kaccount_email'];
                } elseif ($provider == 'naver') {
                    $email = $socialiteUser->user['email'];
                } elseif ($provider == 'facebook') {
                    $email = $socialiteUser->user['email'];
                }
            }
        } catch (Exception $e) {
            log::error([
                'locate'   => 'App\Models\UserSocial@getEmailFromSociliteUser',
                'provider' => $provider,
            ]);
            log::error($e);
        }

        return $email;
    }

    /**
     * @param  string $provider      Social auth provider
     * @param  object $socialiteUser Socialite user object
     * @return string $name
     */
    public function getNameFromSociliteUser($provider, $socialiteUser)
    {
        $name = null;
        $name = $socialiteUser->name;
        try {
            if (empty($name)) {
                if ($provider == 'kakao') {
                    // 없음
                } elseif ($provider == 'naver') {
                    $name = $socialiteUser->user['name'];
                } elseif ($provider == 'facebook') {
                    $name = $socialiteUser->user['name'];
                }
            }
        } catch (Exception $e) {
            log::error([
                'locate'   => 'App\Models\UserSocial@getNameFromSociliteUser',
                'provider' => $provider,
            ]);
            log::error($e);
        }

        return $name;
    }

    /**
     * @param  string $url     RestApi URL
     * @param  string $method  RestApi method
     * @param  array  $headers RestApi headers
     * @param  array  $datas   RestApi form_params
     * @return object $respone
     */
    public static function callRestApi($url, $method, $headers = [], $datas = [])
    {
        $client   = new Client();
        $response = [];
        try {
            $response = $client->request($method, trim($url), [
                'headers'     => $headers,
                'form_params' => $datas,
            ]);
        } catch (GuzzleException $e) {
            Log::warning('callRestApi $response 을 제대로 받지 못함'.$e); // 1001001
        }

        return $response;
    }

    /**
     * 소셜 provider 에서 logout
     * @return void
     */
    public function logout()
    {
        $provider = $this->provider;
        $url      = '';
        $method   = '';
        $headers  = [];
        $datas    = [];

        if ($provider == 'kakao') {
            $url     = 'https://kapi.kakao.com/v1/user/logout';
            $method  = 'POST';
            $headers = ['Authorization' => "Bearer {$this->access_token}"];
        }

        $response = UserSocial::callRestApi($url, $method, $headers, $datas);
        if (!empty($response)) {
        }
    }

    /**
     * 각 소셜 provider 에서 Token 을 갱신하고 DB에 반영한다.
     * @return void
     */
    public function renewToken()
    {
        $provider = $this->provider;

        $url     = '';
        $method  = '';
        $headers = [];
        $datas   = [];

        if ($provider == 'kakao') {
            $url    = 'https://kauth.kakao.com/oauth/token';
            $method = 'POST';
            $datas  = [
                'grant_type'    => 'refresh_token',
                'client_id'     => env('KAKAO_KEY'),
                'refresh_token' => $this->refresh_token,
            ];
        } elseif ($provider == 'naver') {
            $url    = 'https://nid.naver.com/oauth2.0/token';
            $method = 'POST';
            $datas  = [
                'grant_type'    => 'refresh_token',
                'client_id'     => env('NAVER_KEY'),
                'client_secret' => env('NAVER_SECRET'),
                'refresh_token' => $this->refresh_token,
            ];
        } elseif ($provider == 'facebook') {
            $url    = 'https://graph.facebook.com/oauth/access_token';
            $method = 'POST';
            $datas  = [
                'grant_type'        => 'fb_exchange_token',
                'client_id'         => env('FACEBOOK_KEY'),
                'client_secret'     => env('FACEBOOK_SECRET'),
                'fb_exchange_token' => $this->access_token,
            ];
        }
        $response = UserSocial::callRestApi($url, $method, $headers, $datas);
        if (!empty($response)) {
            $tokens = json_decode($response->getBody());
            $this->setTokens($tokens->access_token);
        }
    }

    /**
     * email 이 없는 경우 앱 연결을 끝기 위해서
     * @param  string $provider     Social auth provider
     * @param  string $access_token
     * @param  string $provider_id  Social auth provider Id
     * @return void
     */
    public static function unlink($provider, $access_token, $provider_id = '')
    {
        $url     = '';
        $method  = '';
        $headers = [];
        $datas   = [];

        if ($provider == 'kakao') {
            $url     = 'https://kapi.kakao.com/v1/user/unlink';
            $method  = 'POST';
            $headers = ['Authorization' => "Bearer {$access_token}"];
        } elseif ($provider == 'naver') {
            $url    = ' https://nid.naver.com/oauth2.0/token';
            $method = 'POST';
            $datas  = [
                'grant_type'       => 'delete',
                'client_id'        => env('NAVER_KEY'),
                'client_secret'    => env('NAVER_SECRET'),
                'access_token'     => $access_token,
                'service_provider' => 'naver',
            ];
        } elseif ($provider == 'facebook') {
            $url    = "https://graph.facebook.com/{$provider_id}/permissions";
            $method = 'DELETE';
            $datas  = [
                'access_token' => $access_token,
            ];
        }

        $response = UserSocial::callRestApi($url, $method, $headers, $datas);

        if (!empty($response)) {
            Log::info('unlink userSocial email 제공이 안되 있음'); // 1001001
        }

        return $response;
    }

    /**
     * 각 소셜 provider 에서 연결을 끝고 DB에 Delete 한다.
     * @return void
     */
    public function unregister()
    {
        $response = UserSocial::unlink($this->provider, $this->access_token, $this->provider_id);

        $resultUnlink = false;
        try {
            $body = json_decode($response->getBody());

            if ($provider == 'kakao') {
                if (!!$body->id) {
                    $resultUnlink = true;
                }
            } elseif ($provider == 'naver') {
                if ($body->result == 'success') {
                    $resultUnlink = true;
                }
            } elseif ($provider == 'facebook') {
                if ($body->success == true) {
                    $resultUnlink = true;
                }
            }
        } catch (Exception $e) {
            Log::warning('unregister userSocial respone 이 오류 '.$response); // 1001001
        }

        if ($resultUnlink) {
            // UserSocial::destroy($this->id);
            $this->softDeletes();
        }
    }

    /**
     * @param  string $provider      Social auth provider
     * @param  object $socialiteUser Socialite user object
     * @return string $name
     */
    protected function getNicknameFromSociliteUser($provider, $socialiteUser)
    {
        $nickname = null;
        $nickname = $socialiteUser->nickname;
        try {
            if (empty($nickname)) {
                if ($provider == 'kakao') {
                    $nickname = $socialiteUser->user['properties']['nickname'];
                } elseif ($provider == 'naver') {
                    $nickname = $socialiteUser->user['nickname'];
                } elseif ($provider == 'facebook') {
                    // 없음
                }
            }
        } catch (Exception $e) {
            log::error([
                'locate'   => 'App\Models\UserSocial@getNicknameFromSociliteUser',
                'provider' => $provider,
            ]);
            log::error($e);
        }

        return $nickname;
    }

    /**
     * @param  string $provider      Social auth provider
     * @param  object $socialiteUser Socialite user object
     * @return string $name
     */
    protected function getPhotoFromSociliteUser($provider, $socialiteUser)
    {
        $photoUrl = null;
        $photoUrl = $socialiteUser->avatar;
        try {
            if (empty($name)) {
                if ($provider == 'kakao') {
                    $photoUrl = $socialiteUser->user['properties']['profile_image'];
                    // $photoUrl = $socialiteUser->user['properties']['thumbnail_image']; // 썸네일
                } elseif ($provider == 'naver') {
                    $photoUrl = $socialiteUser->user['profile_image'];
                } elseif ($provider == 'facebook') {
                    // $photoUrl = $socialiteUser->avatar_original; // original image
                }
            }
        } catch (Exception $e) {
            log::error([
                'locate'   => 'App\Models\UserSocial@getPhotoFromSociliteUser',
                'provider' => $provider,
            ]);
            log::error($e);
        }

        return $photoUrl;
    }
}
