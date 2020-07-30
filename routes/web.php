<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    phpinfo();
    return view('welcome');
});
Route::get('/vx/text','Vx\TextController@token');
Route::get('/vx/text2','Vx\TextController@token2');
Route::get('/vx/text3','Vx\TextController@token3');
Route::get('/vx/test','Vx\TextController@test');
Route::get('/vx/aes1','Vx\TextController@aes1');
Route::any('/vx/aes2','Vx\TextController@aes2');
Route::any('/vx/header1','Vx\TextController@header1');
//登录
Route::post('/user/login','LoginController@login');
//注册
Route::post('/user/reg','RegController@reg');
//个人中心
Route::get('/user/center','CenterController@center')->middleware('verifytoken','verifypageviewlogin');
//签到
Route::get('/user/sign','CenterController@sign');
//详情
Route::get('/user/goods','GoodsController@goods')->middleware('verifytoken','verifypageviewlogin');
