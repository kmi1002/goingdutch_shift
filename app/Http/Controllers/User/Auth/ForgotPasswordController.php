<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

use Illuminate\Http\Request;
use DB;
use App\Models\PasswordReset;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
        $this->middleware('guest:user');
    }

    public function forgotForm(Request $request)
    {
        return view('user.auth.password.forgot.index');
    }

    public function forgotEmail(\App\Http\Requests\User\EmailRequest $request)
    {
        try {
            $email = $request->get('email');
            $token = str_random(64);

            // 이메일 조회
            $user = User::withTrashed()->where('email', $email)->first();

            // 비번 초기화 토큰 생성
            PasswordReset::generator($email, $token);

            // 이벤트 발생
            event(new \App\Events\User\ResetPassword($user, $token));

        } catch (\Exception $e) {
        }

        return redirect()->route('user.auth.signin')->with('email_send', $request->email . ' ' . \Lang::get('auth.alert.email_send'));
    }

    public function resetForm(String $token)
    {
        return view('user.auth.password.forgot.reset', ['token' => $token]);
    }

    public function reset(\App\Http\Requests\User\ResetPasswordRequest $request)
    {
        try {
            $token          = $request->token;
            $password       = $request->password;
            $old_password   = $request->old_password;

            PasswordReset::reset($token, $password, $old_password);

            return redirect()->route('user.main.recommend.index');

        } catch (\Exception $e) {
            $code       = $e->getCode();
            $msg        = $e->getMessage();
        }

        return redirect()->back()->withErrors(['forgot_password' => $msg]);
    }
}
