<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\UserBan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class WithdrawalController extends Controller
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


    public function withdrawalForm(Request $request)
    {
        return view('user.auth.withdrawal.index');
    }

    public function confirm(\App\Http\Requests\User\WithdrawalRequest $request)
    {
        try {
            $user_id = \Auth::check() ? \Auth::user()->id : null;

            $pass   = $request->password;
            $reason = $request->reason;

            $user = User::with('userSocial')
                ->where('id', $user_id)
//                ->where('password', $pass)
                ->firstOrFail();

            UserBan::create([
                'reason'        => $reason,
                'expired_at'    => \Carbon\Carbon::now()->toDateTimeString(),
                'user_id'       => $user_id
            ]);

            if ($user) {
                $user->deleted_reason = $reason;
                $user->save();

                $user->delete();
                \Auth::logout();
            }

            return redirect()->route('user.main.recommend.index');

        } catch (\Exception $e) {
            $code       = $e->getCode();
            $msg        = $e->getMessage();
        }

        return redirect()->back()->withErrors(['password_confirmation' => $msg]);

    }
}