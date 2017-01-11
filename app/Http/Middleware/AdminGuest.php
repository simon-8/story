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
        if( session('userid') )
        {
            return redirect(route('getAdminIndex'));
        }
        return $next($request);
    }
}
