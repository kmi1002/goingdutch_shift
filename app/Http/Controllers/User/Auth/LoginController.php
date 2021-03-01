<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Socialite;
use Exception;

use Log;
use App\Models\User;
use App\Models\UserLog;
use App\Models\UserSocial;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:user')->except('logout');
    }

    public function loginForm(Request $request)
    {
        session()->put('link', url()->previous());

        return view('user.auth.login.index');
    }

    public function login(\App\Http\Requests\Auth\LoginRequest $request)
    {
        $user = User::withTrashed()->where('email', $request->email)->first();
        if (!$user) {
            return redirect()->back()->withErrors(['not_user' => \Lang::get('auth.alert.exist_not_email')]);
        }

        // 탈퇴 회원
        if ($user->deleted_at != null) {
            return redirect()->back()->withErrors(['withdrawal_user' => \Lang::get('auth.alert.withdrawal_user')]);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {

            $user = Auth::user();
            UserLog::createLog($user->id);

            $parsed_url = parse_url(session('link'));

            $previous = session('link');

            if (isset($previous) && (strpos($parsed_url['path'], '/auth/') !== 0)) {
                session()->forget('link');

                return redirect($previous);
            }

            return redirect()->route('user.main.recommend.index');
        } else {
            UserLog::createLog(null, '로그인 실패');
            return redirect()->back()->withErrors(['warning_signin' => \Lang::get('auth.alert.warning_signin')]);
        }
    }

    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        // 세션 종료
        $request->session()->invalidate();

        // 이전 페이지 되돌아가기
        $previous = url()->previous();
        if (isset($previous)) {
            return redirect($previous);
        }

        return Redirect()->route('admin.auth.login');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(string $provider, Request $request)
    {
        $user = null;

        try {
            $socialiteUser = Socialite::driver($provider)->stateless()->user();

            if (isset($request->error)) {
                throw new Exception('social auth not agree', 1001001);
            }

            $email = (new UserSocial())->getEmailFromSociliteUser($provider, $socialiteUser);
            if ($email) {
                if (User::existEmail($email) && empty(UserSocial::getUserFromSociliteUser($provider, $socialiteUser))) {
                    throw new Exception('social provider not metch.', 1001003);
                }
            }

        } catch (\Exception $e) {
            switch ((int)$e->getCode()) {
                case 0:
                    Log::warning('Laravel Socialite Error');
                    $error = ['socialite' => \Lang::get('auth.alert.sns_login_error')];
                    break;

                case 1001001:
                    Log::notice('OAuth 동의 않함');
                    $error = ['OAuth' => \Lang::get('auth.alert.sns_login_agree')];
                    break;

                case 1001002:
                    Log::notice('Email 동의 안함');
                    $error = ['email' => \Lang::get('auth.alert.sns_login_email')];
                    break;

                case 1001003:
                    $error = ['email' => \Lang::get('auth.alert.already_user')];
                    break;

                default:
                    $error = [$e->getCode() => $e->getMessage()];
                    break;
            }

            return redirect()
                ->route('user.auth.login')
                ->withErrors(['userSocialsError' => $error]);
        }

        if ($email) {
            if (User::existEmail($email) && $user = UserSocial::getUserFromSociliteUser($provider, $socialiteUser)) {

                $this->guard()->login($user);

                UserLog::createLog($user->id);

                if ($user->activated_at) {
                    $previous = session('link');
                    if (isset($previous)) {
                        session()->forget('link');

                        return redirect($previous);
                    }

                    return redirect()->route('user.main.recommend.index');
                } else {
                    return redirect()->route('user.auth.certification.index');
                }
            }
        }

        session()->put('provider', $provider);
        session()->put('socialiteUser', $socialiteUser);

        return redirect()->route('user.auth.register');
    }
}
