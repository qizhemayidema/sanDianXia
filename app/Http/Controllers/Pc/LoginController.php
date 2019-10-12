<?php

namespace App\Http\Controllers\Pc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\Store as StoreModel;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $name = $request->post('username');
        $pwd = $request->post('password');
        if (!$name || !$pwd){
            return ['code'=>0,'msg'=>'账号或密码必须填写'];
        }
        $res = StoreModel::where(['username'=>$name,'password'=>$pwd])->first();
        if (!$res) return ['code'=>0,'msg'=>'账号或密码错误'];
        if ($res->end_time < time()) return ['code'=>0,'msg'=>'账号已过期'];

        Session::put('pc',$res);

        return ['code'=>1,'msg'=>'success'];
    }
}
