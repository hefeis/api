<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Goods;
use Illuminate\Support\Facades\Redis;

class GoodsController extends Controller
{
    //
    function goods(){
        $goodsinfo=Redis::hgetall('h:goodsinfo');
        if($goodsinfo){
            Redis::hincrby('h:goodsinfo','count',1);
            echo '缓存';
            echo '<hr>';
            print_r($goodsinfo);
        }else{
            $goods_id=request()->get('goods_id');
            $goodsinfo=Goods::select('goods_id','goods_sn','goods_name','cat_id')->find($goods_id);
            $goodsinfo=$goodsinfo->toArray();
            $goodsinfo['count']=1;
            Redis::hmset('h:goodsinfo',$goodsinfo);
            echo '存缓存';
            echo '<hr>';
            print_r($goodsinfo);


        }
    }
}
