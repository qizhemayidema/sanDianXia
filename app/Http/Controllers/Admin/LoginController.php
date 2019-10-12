<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use App\Model\Admin\Manager as ManagerModel;

class LoginController extends Controller
{


    public function index()
    {
        if (Session::has('admin.manager')){
            return redirect()->route('admin.index.index');
        }

        return view('admin.login.index');
    }

    public function check(Request $request)
    {
        $post = $request->post();
        $result = ManagerModel::where('user_name',$post['user_name'])
            ->where('password',md5($post['password']))
            ->first();
        if ($result){
            Session::put('admin.manager',$result);
            return ['code'=>1,'msg'=>'success'];
        }else{
            return ['code'=>0,'msg'=>'账号or密码错误'];
        }

    }

    public function logout()
    {
        Session::remove('admin.manager');
        return $this->index();
    }
}
