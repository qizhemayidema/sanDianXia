<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Image;


class ServiceNetworkController extends Controller
{
    public function index(){
        $res = Image::where(['type'=>2])->get();

        return view('admin.serviceNetwork.index',compact('res'));
    }

    public function add(){
        return view('admin.serviceNetwork.add');
    }

    public function save(Request $request){
        $url = $request->post('url');
        Image::insert(['url'=>$url,'type'=>2]);
        return ['code'=>1,'msg'=>'success'];
    }

    public function edit(){

    }

    public function update(){

    }

    public function delete($role_id){
        Image::where(['id'=>$role_id])->delete();
        return ['code'=>1,'msg'=>'success'];
    }
}
