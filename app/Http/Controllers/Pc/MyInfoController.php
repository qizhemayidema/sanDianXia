<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MyInfoController extends BaseController
{
    public $my_type = 'info';

    public $page_type = '';

    public function index()
    {
        $data = Store::where(['id'=>Session::get('pc')->id])->first();
        return view('pc.my.info',compact('data'))->with([
            'my_type'=>$this->my_type,
            'page_type'=>$this->page_type,
            'config' => $this->configObject
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->post();
        $rules = [
            'store_name'    => 'required|max:30',
            'contact'       => 'required|max:10',
            'phone'         => 'required|max:11',
            'business_scope' => 'required|max:60',
            'area'          => 'required|max:64',
        ];

        $messages = [
            'store_name.required'   => '公司名称必须填写',
            'store_name.max'        => '公司名称最大为30字',
            'phone.required'        => '联系电话必须填写',
            'phone.max'              => '联系电话最大为11字',
            'contact.required'      => '销售工程师必须填写',
            'contact.max'           => '销售功能师最大为10字',
            'business_scope.required' => '经营范围必须填写',
            'business_scope.max' => '经营范围最大为60字',
            'area.required' => '联系地址必须填写',
            'area.max' => '联系地址最大为64字',
        ];

        $validate = Validator::make($data,$rules,$messages);
        if ($validate->fails()){
            return ['code'=>0,'msg'=>$validate->errors()->first()];
        }
        $result = [
            'store_name'    => $data['store_name'],
            'contact'       => $data['contact'],
            'phone'         => $data['phone'],
            'business_scope'=> $data['business_scope'],
            'area'          => $data['area'],
        ];
        //上传logo
        $logo = $request->file('logo');
        $banner = $request->file('banner');
        if ($logo && $logo->isValid()){
            $ext = $logo->getClientOriginalExtension();//文件拓展名

            if (!in_array($ext,['jpg','jpeg','gif','png'])){
                return ['code'=>0,'msg'=>'图片格式不正确'];
            }
            if ($logo->getSize() / 1024 / 1024 > 3){
                return ['code'=>0,'msg'=>'封面图不得超过3mb大小'];
            }

            $result['logo'] = $logo->store('upload');
        }
        if ($banner && $banner->isValid()){
            $ext = $banner->getClientOriginalExtension();//文件拓展名

            if (!in_array($ext,['jpg','jpeg','gif','png'])){
                return ['code'=>0,'msg'=>'图片格式不正确'];
            }
            if ($banner->getSize() / 1024 / 1024 > 3){
                return ['code'=>0,'msg'=>'封面图不得超过3mb大小'];
            }

            $result['banner'] = $banner->store('upload');
        }

        Store::where(['id'=>Session::get('pc')->id])->update($result);
        return ['code'=>1,'msg'=>'success'];
    }
}
