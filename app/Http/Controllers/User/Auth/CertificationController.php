<?php
namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\User;

class CertificationController extends Controller
{
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

    public function index() {
        return view('user.auth.signup.certification');
    }

    public function store(Request $request, String $token)
    {
        $user = User::where('activation_code', $token)->first();

        if ($user) {
            $user->activation_code  = null;
            $user->activated_at = \Carbon\Carbon::now()->toDateTimeString();
            $user->save();

            //TODO:: 에러 발생
//            auth()->loginUsingId($user->id);

            return view('user.auth.signup.congratulation');
        } else {

//            if ($user->activated_at) {
//                dd('이미 인증 받음');
//            } else {
//                dd('다시 받아 볼래?');
//            }
        }
    }

    public function reset(Request $request)
    {
        try {
            $email = $request->get('email');

            $user = User::withTrashed()
                ->where('email', $email)
                ->whereNotNull('activation_code')
                ->firstOrFail();

            if ($user) {
                $user->activation_code = str_random(64);
                $user->save();

                event(new \App\Events\User\RegisterManager($user));
            }

        } catch (\Exception $e) {
        }

        return redirect()->route('user.main.recommend.index');
    }

    public function congratulation()
    {
        return view('user.auth.signup.congratulation');
    }
}
