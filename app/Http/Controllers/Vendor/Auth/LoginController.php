<?php

namespace App\Http\Controllers\Vendor\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Illuminate\Http\Request;
use Auth;

use App\Models\UserLog;

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
    protected $redirectTo = '/vendor/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:vendor')->except('logout');
    }

    public function loginForm(Request $request)
    {
        return view('vendor.auth.login.index');
    }

    public function login(Request $request)
    {
        try {
            // 관리자 세션으로 로그인 시도
            if (Auth::guard('vendor')->attempt(['email' => $request->email, 'password' => $request->password])) {

                // 관리자 정보
                $user = Auth::guard('vendor')->user();

                // 활성화 되어 있는지 확인
                if (!$user->isActivated()) {
                    throw new \Exception(\Lang::get('auth.alert.warning_confirm'), 100);
                }

                // 관리자 권한 확인
                if (!$user->isVendor()) {
                    throw new \Exception('관리자 권한이 아닙니다.', 101);
                }

                // 로그인 로그 저장
                UserLog::createLog($user->id);

                return redirect()->route('vendor.dashboard.index');
            }

            $message = \Lang::get('auth.alert.warning_login');

        } catch (\Exception $e) {
            $message = $e->getMessage();
        }

        UserLog::createLog(null, '관리자 로그인 실패 : ' . $message);

        return redirect()->back()->withErrors(['warning_login' => $message]);
    }


    public function logout(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (Auth::guard('vendor')->check()) {
            Auth::guard('vendor')->logout();
        }

        // 사용자 로그인을 한 경우에는 세션을 유지하기 때문에 초기화 하면 안된다.
//        $request->session()->invalidate();

        return Redirect()->route('vendor.auth.login');
    }
}
