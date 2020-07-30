<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use App\Reg;

class CenterController extends Controller
{
    //
    function center(){
        $get_token=request()->get('token');
        $black_token=Redis::sismember('black_token',$get_token);
        if($black_token){
            Redis::del("token");
            Redis::del("user_id");
            die('由于访问次数过多以添加到黑名单');
        }
        $user_id=Redis::get('user_id');
        $userinfo=Reg::find($user_id);
        $response=[
            'error'=>0,
            'msg'=>'欢迎'.$userinfo['username'].'进入个人中心'
        ];
        return $response;
    }
    function sign(){
        $key="ss:user_sign".date('ymd');
        $sign_count=Redis::zcard($key);
        if($sign_count>0){
            return '您今天已经签到过了哦';
        }else{
            $user_id=Redis::get('user_id');
            Redis::zadd($key,time(),$user_id);
            return '签到成功';
        }





    }
}
