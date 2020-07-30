<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class Verifypageview
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
        if(!Redis::get('user_id')){
            $url=$request->url();
            Redis::zincrby('sz:pageview',1,$url);
            $pageview=Redis::zrange('sz:pageview',0,-1,true);
            echo "没登录";
            var_dump($pageview);
            return $next($request);
        }
    }
}
