<?php

namespace App\Http\Controllers\Vx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Redis;

class TextController extends Controller
{
    //
    function token(){
        $appid="wxb43a67ebe1bd2a26";
        $secret="8ca5384405b188d4a4f9aa2462f0078e";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $result=file_get_contents($url);
        dd($result);
    }
    function token2(){
        $appid="wxb43a67ebe1bd2a26";
        $secret="8ca5384405b188d4a4f9aa2462f0078e";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $ch=curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $result = curl_exec($ch);
        curl_close($ch);
        dd($result);

    }
    function  token3(){
        $appid="wxb43a67ebe1bd2a26";
        $secret="8ca5384405b188d4a4f9aa2462f0078e";
        $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret;
        $client=new Client();
        $response = $client->request('get',$url);
        $result=$response->getBody();
        echo $result;
    }
    function test(){
        $store=Redis::llen('store');
        $storeinfo=Redis::lrange('store',0,-1);
        if(!$storeinfo){
            Redis::lpush('store',1,1,1,1,1,1,1,1,1,1);
        }
        if($store>0){
            Redis::lpop('store');
            $content='库存-1';
            echo $content."库存剩余".$store;
            die;
        }else{
            $content="库存没有咯!";
            echo $content."库存剩余".$store;
            die;
        }

    }
    function aes1(){
        $data="你想吃饭吗";
        $method="AES-128-CBC";
        $key="1911php";
        $iv="1111111111111111";
        $enaes_data=base64_encode(openssl_encrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv));
        $url="http://www.com/vx/aes1";
        $data=['form_params' => ['enaes_data'=>$enaes_data]];
        $client=new Client();
        $response = $client->request('post',$url,$data);
        $result=$response->getBody();
        echo "加密后".$enaes_data;echo "<br>";
        echo "解密后".$result;echo "<br>";
//        $data=base64_decode($enaes_data);
//        $deaes_data=openssl_decrypt($data,$method,$key,OPENSSL_RAW_DATA,$iv);
//        echo '|';
//        echo $deaes_data;
    }
    function aes2(){
        if(request()->isMethod('get')){
            $data="吃饭干嘛呀";
            $content=file_get_contents(storage_path('key/pub.www.key'));
            $key=openssl_get_publickey($content);
            openssl_public_encrypt($data,$enpub_data,$key);
            $content2=file_get_contents(storage_path('key/priv.key'));
            $key2=openssl_get_privatekey($content2);
            $enpub_data=base64_encode($enpub_data);
            openssl_sign($enpub_data,$sign,$key2);
            echo "api解密前:  ".$enpub_data;echo '<hr>';
            $url="https://hefei.phpclub.icu/index.php/vx/aes2";
            $data=['form_params' => ['enpub_data'=>$enpub_data,'sign'=>$sign]];
            $client=new Client();
            $response = $client->request('post',$url,$data);
            $result=$response->getBody();
            echo $result;echo '<hr>';
            die;
        }
        if(request()->isMethod('post')){
            $key2="1911php";
            $sign=request()->post('sign');
            $enpub_data=request()->post('enpub_data');
            if(md5($key2.$enpub_data)==$sign){
                $enpub_data=base64_decode($enpub_data);
                $content=file_get_contents(storage_path('key/priv.key'));
                $key=openssl_get_privatekey($content);
                openssl_private_decrypt($enpub_data,$depri_data,$key);
                echo $depri_data;
                die;
            }else{
                echo '数据被改了哦';
                die;
            }
        }

    }
    function header1(){
        $url="http://www.com/vx/header1";
        $uid=12312;
        $token="haaisdjknandjkw";
        $headers=[
          'uid:'.$uid,
            'token:'.$token
        ];
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_exec($ch);
        curl_close($ch);

    }
}
