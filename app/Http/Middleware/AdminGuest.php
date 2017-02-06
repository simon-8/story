<?php

/*
 * 后台中间件
 * 必须在未登录状态下访问
 *
 * */
namespace App\Http\Middleware;

use Closure;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if( session('userinfo') )
        {
            return redirect(route('Admin.getIndex'));
        }
        return $next($request);
    }
}
