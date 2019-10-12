<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Common\QueueController;
use App\Jobs\HandleMessage;
use App\Model\Admin\Attribute;
use App\Model\Admin\Message;
use App\Model\Admin\Vip;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Admin\Category as CateModel;
use App\Model\Admin\Attribute as AttrModel;
use App\Model\Admin\Message as MessageModel;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class MessageController extends BaseController
{
    public function index()
    {
        $data = MessageModel::leftJoin('attribute',function($join){
            $join->on('attribute.id','=','message.attr_id');
        })->select('attribute.attr_name','message.*')
        ->orderBy('id','desc')->where(['message.delete_time'=>0])->paginate(15);
        return view('admin.message.index',compact('data'));
    }

    public function add()
    {
        $cateInfo = CateModel::all()->toArray();
        $cate_id = count($cateInfo) ? $cateInfo['0']['id'] : 0;
        $attrInfo = AttrModel::where(['cate_id'=>$cate_id])->get()->toArray();
        return view('admin.message.add',compact('cateInfo','attrInfo'));
    }

    public function save(Request $request)
    {
        $post = $request->post();
        $rules = [
            'name'          => 'required|max:6',
            'cate_id'       => 'required',
            'attr_id'       => 'required',
            'area'          => 'required',
            'address'       => 'required|max:128',
            'phone'         => 'required|max:11',
            'title'         => 'required|max:20',
            'content'       => 'required|max:999',
            'msg_price'     => 'required|numeric|max:99',
            'validity_time' => 'required|date',
        ];
        $messages = [
            'name.required' => '称呼必填',
            'name.max'      => '称呼最大长度为6',
            'attr_id.required' => '所属必须选择',
            'area.required'  => '必须选择地区',
            'address.required' => '必须填写详细地址',
            'address.max'      => '详细地址最大长度为128',
            'phone.required'    => '手机号必须填写',
            'phone.max'        => '手机号最大长度为11',
            'title.required'    => '必须填写标题',
            'title.max'        =>  '标题最大长度为20',
            'content.required' =>  '详细需求必须填写',
            'content.max'       => '详细需求最大长度为999',
            'msg_price.required' => '商机价格必须填写',
            'msg_price.max'     => '商机最多不能超过99元',
            'validity_time.required' => '有效期必须选择',
            'validity_time.date' => '有效期必须为日期',
        ];

        $validate = Validator::make($post,$rules,$messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        $area = explode(' ',$post['area']);
        $validity_time = strtotime($post['validity_time']);
        if ($validity_time <= time()){
            return ['code'=>0,'msg'=>'有效期不能小于当前时间'];
        }

        $data = [
            'name' => $post['name'],
            'cate_id' => $post['cate_id'],
            'attr_id' => $post['attr_id'],
            'province' => $area[0],
            'city'      => $area[1] ?? '',
            'area'      => $area[2] ?? '',
            'address'   => $post['address'],
            'phone'     => $post['phone'],
            'title'     => $post['title'],
            'content'   => $post['content'],
            'msg_price' => $post['msg_price'],
            'validity_time' =>$validity_time,
            'create_time' => time(),
            'status'    => 2,
        ];
        $data['id'] = MessageModel::insertGetId($data);

        $vipInfo = Vip::get();

        (new QueueController())->publishMessageToSubscriberByWechatPublicNumber($data);

        return ['code'=>1,'msg'=>'发布成功'];

    }

    public function edit(MessageModel $msg)
    {
        $cateInfo = CateModel::all()->toArray();

        $attrInfo = AttrModel::where(['cate_id'=>$msg->cate_id])->get()->toArray();
        return view('admin.message.edit',compact('cateInfo','attrInfo','msg'));

    }

    public function update($msg)
    {
        $post = request()->post();
        $rules = [
            'name'          => 'required|max:6',
            'cate_id'       => 'required',
            'attr_id'       => 'required',
            'area'          => 'required',
            'address'       => 'required|max:128',
            'phone'         => 'required|max:11',
            'title'         => 'required|max:20',
            'content'       => 'required|max:999',
            'msg_price'     => 'required|numeric|max:99',
            'validity_time' => 'required|date',
        ];
        $messages = [
            'name.required' => '称呼必填',
            'name.max'      => '称呼最大长度为6',
            'attr_id.required' => '所属必须选择',
            'area.required'  => '必须选择地区',
            'address.required' => '必须填写详细地址',
            'address.max'      => '详细地址最大长度为128',
            'phone.required'    => '手机号必须填写',
            'phone.max'        => '手机号最大长度为11',
            'title.required'    => '必须填写标题',
            'title.max'        =>  '标题最大长度为20',
            'content.required' =>  '详细需求必须填写',
            'content.max'       => '详细需求最大长度为999',
            'msg_price.required' => '商机价格必须填写',
            'msg_price.max'     => '商机最多不能超过99元',
            'validity_time.required' => '有效期必须选择',
            'validity_time.date' => '有效期必须为日期',
        ];

        $validate = Validator::make($post,$rules,$messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        $area = explode(' ',$post['area']);
        $validity_time = strtotime($post['validity_time']);
        if ($validity_time <= time()){
            return ['code'=>0,'msg'=>'有效期不能小于当前时间'];
        }
        $data = [
            'name' => $post['name'],
            'cate_id' => $post['cate_id'],
            'attr_id' => $post['attr_id'],
            'province' => $area[0],
            'city'      => $area[1] ?? '',
            'area'      => $area[2] ?? '',
            'address'   => $post['address'],
            'phone'     => $post['phone'],
            'title'     => $post['title'],
            'content'   => $post['content'],
            'msg_price' => $post['msg_price'],
            'validity_time' =>$validity_time,
            'create_time' => time(),
            'status'    => 2,
        ];
        $data['id'] = MessageModel::where(['id'=>$msg])->update($data);

        return ['code'=>1,'msg'=>'修改成功'];

    }

    public function delete($msg)
    {
        MessageModel::where(['id'=>$msg])->update(['delete_time'=>time()]);
        return ['code'=>1,'msg'=>'success'];
    }

    public function checkStatus(MessageModel $msg)
    {
        $cate = CateModel::get();

        $user_attr = $msg->attr_id ? Attribute::where(['id'=>$msg->attr_id])->first()->toArray() : [];

        $attr = $cate ? $user_attr ? Attribute::where(['cate_id'=>$user_attr['cate_id']])->get()->toArray() : [] : []; ;


        return view('admin.message.status',compact('msg','cate','user_attr','attr'));
    }

    public function getAttr()
    {
        $cate_id = request()->post('cate_id');
        $attrInfo = AttrModel::where(['cate_id'=>$cate_id])->get();
        return ['code'=>1,'data'=>$attrInfo];
    }

    public function changeStatus(Request $request)
    {
        $status = $request->post('status');
        $id = $request->post('id');
        $attr_id = $status == 2 ? $request->post('attr') : 0;
        $cate_id = $status == 2 ? $request->post('cate') : 0;
//        $arr = [0,1,2];
//        if (!in_array($status,$arr)){
//            return ['code'=>0,'msg'=>'操作失误'];
//        }
        MessageModel::where(['id'=>$id])->update(['status'=>$status,'attr_id'=>$attr_id,'cate_id'=>$cate_id]);

        if ($status == 2){
            (new QueueController())
                ->publishMessageToSubscriberByWechatPublicNumber(MessageModel::where(['id'=>$id])->first()->toArray());
        }
        return ['code'=>1,'msg'=>'success'];
    }
}
