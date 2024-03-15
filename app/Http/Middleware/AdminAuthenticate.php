<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminAuthenticate
{
   /**
 * Handle an incoming request.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Closure  $next
 * @param  string|null  $guard
 * @return mixed
 */
    public function handle(Request $request, Closure $next, $guard = 'admin')
    {
        // 登入驗證邏輯
        if (!Auth::guard($guard)->check()) {
            return redirect()->route('admin.login.show');
        }
        return $next($request);
    }
}
