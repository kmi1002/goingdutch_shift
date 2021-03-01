<?php

namespace App\Http\Controllers\Admin\Auth;

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
    protected $redirectTo = '/admin/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // __construct >> handle >> unauthenticated >> loginForm

        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function loginForm(Request $request)
    {
        return view('admin.auth.login.index');
    }

    public function login(\App\Http\Requests\Auth\LoginRequest $request)
    {
        try {
            // 관리자 세션으로 로그인 시도
            if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {

                // 관리자 정보
                $user = Auth::guard('admin')->user();

                // 활성화 되어 있는지 확인
                if (!$user->isActivated()) {
                    throw new \Exception(\Lang::get('auth.alert.warning_confirm'), 100);
                }

                // 관리자 권한 확인
                if (!$user->isAdmin()) {
                    throw new \Exception('관리자 권한이 아닙니다.', 101);
                }

                // 로그인 로그 저장
                UserLog::createLog($user->id);

                return redirect()->route('admin.dashboard.index');
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
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();

        return Redirect()->route('admin.auth.login');
    }
}
