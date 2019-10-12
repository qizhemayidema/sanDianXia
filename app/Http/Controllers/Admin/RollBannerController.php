<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Image;

class RollBannerController extends BaseController
{
    public function index(){
        $res = Image::where(['type'=>1])->get();

        return view('admin.rollBanner.index',compact('res'));
    }

    public function add(){
        return view('admin.rollBanner.add');
    }

    public function save(Request $request){
        $url = $request->post('url');
        Image::insert(['url'=>$url,'type'=>1]);
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
