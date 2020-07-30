<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class Verifypageviewlogin
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
        if(Redis::get("user_id")){
            $url=$request->url();
            $key="h:pageview".Redis::get('user_id');
            Redis::hincrby($key,$url,1);
            echo '登录过了';
            return $next($request);
        }
    }
}
