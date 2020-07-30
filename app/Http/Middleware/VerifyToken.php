<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Redis;

class VerifyToken
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
        $gettoken=$request->get('token');
        if($gettoken){
            $token=Redis::get('token');
            if($gettoken==$token){
                return $next($request);
            }else{
                $response=[
                    'error'=>40002,
                    'msg'=>'token有误请重新获取'
                ];
                    $url=$request->url();
                    Redis::zincrby('sz:pageview',1,$url);
                    $pageview=Redis::zrange('sz:pageview',0,-1,true);
                    echo "没登录";
                    var_dump($pageview);
                $response=json_encode($response);
                echo $response;
                die;
            }
        }else{
            $url=$request->url();
            Redis::zincrby('sz:pageview',1,$url);
            $pageview=Redis::zrange('sz:pageview',0,-1,true);
            echo "没登录";
            var_dump($pageview);
            die('授权失败');
        }
    }
}
