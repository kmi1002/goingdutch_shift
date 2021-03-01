<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use App\Models\PasswordReset;


class ResetPasswordController extends Controller
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

    public function resetForm(String $token)
    {
        return view('user.auth.password.reset.change', ['token' => $token]);
    }

    public function reset(\App\Http\Requests\User\ResetPasswordRequest $request)
    {
        try {
            $token          = $request->token;
            $password       = $request->password;
            $old_password   = $request->old_password;

            PasswordReset::reset($token, $password, $old_password);
            return redirect()->route('user.mypage.setting.index')->with('change_password', \Lang::get('auth.alert.change_password'));

        } catch (\Exception $e) {
            $code       = $e->getCode();
            $msg        = $e->getMessage();
        }

        return redirect()->back()->withErrors(['forgot_password' => $msg]);
    }
}
