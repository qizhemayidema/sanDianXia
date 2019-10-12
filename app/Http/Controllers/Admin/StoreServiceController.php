<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\StoreService as StoreServiceModel;
use App\Model\Admin\Vip as ViPModel;
use App\Model\Admin\User as UserModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StoreServiceController extends BaseController
{
    public function index()
    {
//        $storeInfo = StoreServiceModel::alias('')

        $storeInfo = DB::table('store_service')->leftJoin('vip',function($join){
            $join->on('vip.id','=','store_service.vip_id');
        })->orderBy('store_service.id','desc')->select('store_service.*','vip.name as vip_name')->paginate(15);

        return view('admin.storeService.index',compact('storeInfo'));
    }

    public function add()
    {
        //查询vip
        $vip = DB::table('vip')->orderBy('money','desc')
            ->select('name','id')->get()->toArray();
        return view('admin.storeService.add',compact('vip'));
    }

    public function save(Request $request)
    {
        $post = $request->post();
        $rules = [
            'name' => 'required|max:10',
            'money' => 'required|numeric|max:1000000',
        ];
        $messages = [

            'money.required' => '价格必须填写',
            'money.numeric' => '价格必须是数字',
            'money.max' => '价格必须最大为1000000',
            'name.required' => '名称必须填写',
            'name.max' => '名称最大长度为10',

        ];
        $validate = Validator::make($post, $rules, $messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        $insert = [
            'money' => $post['money'],
            'name'  => $post['name'],
        ];
        if (isset($post['is_vip'])){
            if (!isset($post['vip_id'])){
                return ['code'=>0,'msg'=>'必须选择一个vip'];
            }
            $insert['vip_id'] = $post['vip_id'];
        }
        DB::table('store_service')->insert($insert);
        return ['code'=>1,'msg'=>'success'];
    }

    public function edit($service_id)
    {
        $vip = ViPModel::all();
        $service =  StoreServiceModel::where(['id'=>$service_id])->first()->toArray();
        return view('admin.storeService.edit',compact('vip','service'));
    }

    public function update($service_id)
    {
        $post = request()->post();
        $rules = [
            'name' => 'required|max:10',
            'money' => 'required|numeric|max:1000000',
        ];
        $messages = [

            'money.required' => '价格必须填写',
            'money.numeric' => '价格必须是数字',
            'money.max' => '价格必须最大为1000000',
            'name.required' => '名称必须填写',
            'name.max' => '名称最大长度为10',

        ];
        $validate = Validator::make($post, $rules, $messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        $update = [
            'money' => $post['money'],
            'name'  => $post['name'],
        ];
        if (isset($post['is_vip'])){
            if (!isset($post['vip_id'])){
                return ['code'=>0,'msg'=>'必须选择一个vip'];
            }
            $update['vip_id'] = $post['vip_id'];
        }else{
            $update['vip_id'] = 0;
        }
        DB::table('store_service')->where(['id'=>$service_id])->update($update);
        return ['code'=>1,'msg'=>'success'];
    }

    public function delete($service_id){
        //判断是否有用户开通了此项功能
        $is_exists = UserModel::where(['store_service_id'=>$service_id])->first();
        if ($is_exists){
            return ['code'=>0,'msg'=>'有用户开通此服务,无法删除'];
        }
        StoreServiceModel::where(['id'=>$service_id])->delete();
        return ['code'=>1,'msg'=>'success'];
    }
}
