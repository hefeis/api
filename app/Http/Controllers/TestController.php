<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    function login(Request $request){
        print_r($request->post());
    }
}
