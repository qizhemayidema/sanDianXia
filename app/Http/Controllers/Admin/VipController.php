<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Vip as VipModel;
use Illuminate\Support\Facades\Validator;
use App\Model\Admin\User as UserModel;
use App\Model\Admin\StoreService as StoreServiceModel;

class VipController extends BaseController
{
    public $normalUserPushTime;

    public function __construct()
    {
        parent::__construct();
        $this->normalUserPushTime = config('app.normal_user');

    }

    public function index()
    {
        //查询vip信息
        $vipInfo = VipModel::orderBy('id', 'desc')->paginate(15);

        $normalUserPushTime = $this->normalUserPushTime;

        return view('admin.vip.index', compact('vipInfo', 'normalUserPushTime'));
    }

    //返回添加页面
    public function add()
    {
        $normalUserPushTime = $this->normalUserPushTime;

        return view('admin.vip.add', compact('normalUserPushTime'));
    }

    public function save(Request $request)
    {
        $normalUserPushTime = $this->normalUserPushTime;

        $post = $request->post();
        $rules = [
            'discount' => 'required|numeric|max:10',
            'money' => 'required|numeric|max:1000000',
            'name' => 'required|max:10',
            'precedence' => 'required|numeric|max:300',
        ];
        $messages = [
            'discount.required' => '折扣必须填写',
            'discount.numeric' => '折扣必须是数字',
            'discount.max' => '折扣最大长度为10',
            'money.required' => '价格必须填写',
            'money.numeric' => '价格必须是数字',
            'money.max' => '价格必须最大为1000000',
            'name.required' => '名称必须填写',
            'name.max' => '名称最大长度为10',
            'precedence.required' => '推送秒数必须填写',
            'precedence.numeric' => '推送秒数必须是数字',
            'precedence.max' => '推送秒数最大长度为300',
        ];
        $validate = Validator::make($post, $rules, $messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        if ($post['precedence'] > $normalUserPushTime) {
            return ['code' => 0, 'msg' => '推送描述最大不能超过' . $normalUserPushTime];
        }
        $result = [
            'discount' => $post['discount'],
            'money' => $post['money'],
            'name' => $post['name'],
            'precedence' => $post['precedence'],
        ];
        //计算到底延时多少
        $result['delay'] = $normalUserPushTime - $post['precedence'];
        VipModel::insert($result);

        return ['code' => 1, 'msg' => 'success'];
    }

    public function edit(VipModel $vip_id)
    {
        $normalUserPushTime = $this->normalUserPushTime;

        return view('admin.vip.edit', compact('vip_id', 'normalUserPushTime'));
    }

    public function update($vip_id)
    {
        $post = request()->post();
        $normalUserPushTime = $this->normalUserPushTime;
        $rules = [
            'discount' => 'required|numeric|max:10',
            'money' => 'required|numeric|max:1000000',
            'name' => 'required|max:10',
            'precedence' => 'required|numeric|max:300',
        ];
        $messages = [
            'discount.required' => '折扣必须填写',
            'discount.numeric' => '折扣必须是数字',
            'discount.max' => '折扣最大长度为10',
            'money.required' => '价格必须填写',
            'money.numeric' => '价格必须是数字',
            'money.max' => '价格必须最大为1000000',
            'name.required' => '名称必须填写',
            'name.max' => '名称最大长度为10',
            'precedence.required' => '推送秒数必须填写',
            'precedence.numeric' => '推送秒数必须是数字',
            'precedence.max' => '推送秒数最大长度为300',
        ];
        $validate = Validator::make($post, $rules, $messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        if ($post['precedence'] > $normalUserPushTime) {
            return ['code' => 0, 'msg' => '推送描述最大不能超过' . $normalUserPushTime];
        }
        $result = [
            'discount' => $post['discount'],
            'money' => $post['money'],
            'name' => $post['name'],
            'precedence' => $post['precedence'],
        ];
        //计算到底延时多少
        $result['delay'] = $normalUserPushTime - $post['precedence'];
        VipModel::where(['id' => $vip_id])->update($result);

        return ['code' => 1, 'msg' => 'success'];
    }

    public function delete($vip_id)
    {
        $is_exists = UserModel::where(['vip_id' => $vip_id])->first();
        if ($is_exists) {
            return ['code' => 0, 'msg' => '该vip下有用户,无法删除'];
        }
        $service_is_exists = StoreServiceModel::where(['vip_id'=>$vip_id])->first();
        if ($service_is_exists){
            return ['code' => 0, 'msg' => '店铺服务与该vip有关联,无法删除'];
        }
        VipModel::where(['id' => $vip_id])->delete();

        return ['code' => 1, 'msg' => 'success'];
    }
}
