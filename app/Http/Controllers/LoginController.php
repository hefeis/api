<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reg;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class LoginController extends Controller
{
    //
    function login(){
        $reg=new Reg();
        $user_name=request()->post('user_name','');
        $password=request()->post('password','');
        $arr=$reg->where('user_name',$user_name)->first();
        if(!empty($arr)){
            if($arr['password']==$password){
                $token=Str::random(32);
                if(Redis::get('token')){
                    $count=Redis::incr('count');
                    Redis::expire('count',60);
                    if($count>10){
                        $response=[
                            'error'=>300001,
                            'msg'=>'访问次数过多',
                        ];
                        Redis::sadd('black_token',$token);
                        return $response;
                    }else{
                        $response=[
                            'error'=>0,
                            'msg'=>'登录成功1',
                            'data'=>[
                                'token'=>$token
                            ]
                        ];
                        Redis::set('token',$token);
                        Redis::set('user_id',$arr['user_id']);
                        Redis::incr('count');
                        Redis::expire('count',60);
                        return $response;
                    }
                }
                Redis::set('token',$token);
                Redis::set('user_id',$arr['user_id']);
                Redis::incr('count');
                Redis::expire('count',60);
                $response=[
                  'error'=>0,
                  'msg'=>'登录成功2',
                    'data'=>[
                        'token'=>$token
                    ]
                ];
                return $response;
            }else{
                $response=[
                    'error'=>50004,
                    'msg'=>'密码错误'
                ];
                return $response;
            }
        }else{
            $response=[
                'error'=>50003,
                'msg'=>'没有此用户'
            ];
            return $response;
        }
    }
}
