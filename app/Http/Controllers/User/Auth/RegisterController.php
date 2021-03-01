<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Symfony\Component\Routing\Route;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;
    use SoftDeletes;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
        $this->middleware('guest:user');
    }

    private function checkEmail(String $email)
    {
        $message = '';
        try {
            $users = User::withTrashed()->where('email', $email)->first();

            if (empty($users)) {
                $message = '';
            } else {
                if ($users->trashed()) {
                    $message = Lang::get('auth.alert.deleted_user');
                } else {
                    $message = Lang::get('auth.alert.already_user');
                }
            }
        } catch (\Exception $e) {
            logger()->error($e);
        }

        return $message;
    }

    public function signupForm(Request $request)
    {
//        dd(empty($errors), isset($errors));
        return view('user.auth.signup.index');
    }

    public function register(\App\Http\Requests\User\RegisterRequest $request)
    {
        if ($user = User::createUser($request->all())) {

            // 자동 로그인
            \Auth::attempt(['email' => $request->email, 'password' => $request->password]);

            if ($user->isUserSocial()) {
                $this->guard()->login($user);
            } else {
                event(new \App\Events\User\RegisterManager($user));
            }

            $parsed_url = parse_url(session('link'));

            $previous = session('link');
            if (isset($previous) && (strpos($parsed_url['path'], '/auth/') !== 0)) {
                session()->forget('link');

                return redirect($previous);
            }

            return redirect()->route('user.main.recommend.index')->with('email_send', $request->email . ' ' . \Lang::get('auth.alert.email_send'));
        }

        return redirect()->back()->withErrors(['warning_signup' => \Lang::get('auth.alert.warning_signup')]);
    }

    public function withdrawal(Request $request)
    {

    }

}
