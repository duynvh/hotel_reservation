<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AuthAdmin
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
//        if (Auth::guard($guard)->check()) {
//            return redirect('/home');
//        }

        // Đã login
        if (Auth::check()) {
            // Nếu là admin thì đi tiếp
//            if (Auth::user()->isAdmin()) {
                return $next($request);
//            } else {
//                dd(1);
//                // nếu không phải là admin thì vào trang học viên. Sau đó về trang học viên check login và redirect tiếp
//                return redirect()->guest(route('admin.login'));
//            }
        }
        else {
            if ($request->ajax()) {
                return response('Unauthorized', 401);
            } else {
                return redirect()->guest(route('admin.login'));
            }
        }
    }
}
