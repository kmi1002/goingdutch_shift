<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        // guard(세션)에 따른 로그인 경로 설정한다
        switch ($guard) {
            case 'admin':
                $redir = 'admin.dashboard.index';
                break;

            case 'vendor':
                $redir = 'vendor.dashboard.index';
                break;

            default:
                $redir = 'user.main.index';
                break;
        }

        // 해당 guard(세션)가 있을 경우 $request를 진행한다
        if (Auth::guard($guard)->check()) {
            return redirect()->route($redir);
        }

        // 로그인 페이지로 이동한다
        return $next($request);
    }
}
