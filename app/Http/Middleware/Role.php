<?php
namespace App\Http\Middleware;

use Auth;
use Closure;

class Role
{
    public function handle($request, Closure $next, ... $roles)
    {
        if (!\Auth::check())
            return Redirect()->route('user.auth.login');

        $user = \Auth::user();
        if ($user->hasRole($roles)) {
            return $next($request);
        }

//        if (Auth::guard('admin')->check()) {
//            return Redirect()->route('admin.auth.login');
//        } else if (Auth::guard('vendor')->check()) {
//            return Redirect()->route('vendor.auth.login');
//        }

        return Redirect()->route('user.auth.login');
    }
}