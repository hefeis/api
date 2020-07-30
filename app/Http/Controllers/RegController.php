<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reg;

class RegController extends Controller
{
    //
    function reg(){
        $user_name=request()->post('user_name','');
        $password=request()->post('password','');

        if(empty($user_name)){
            $response=[
              'error'=>50001,
              'msg'=>"用户名不为空"
            ];
            return $response;
        }
        if(empty($password)){
            $response=[
                'error'=>50002,
                'msg'=>"密码不能为空"
            ];
            return $response;
        }
        $reg=new Reg();
        $reg->user_name=request()->post('user_name','');
        $reg->password=request()->post('password','');
        if($reg->save()){
            $response=[
                'error'=>0,
                'msg'=>"注册成功"
            ];
            return $response;
        }
    }
}
