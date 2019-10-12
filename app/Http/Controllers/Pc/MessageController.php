<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\Message;
use App\Model\Index\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class MessageController extends BaseController
{
    public function save(Request $request)
    {
        $post = $request->post();
        $rules = [
            'name'          => 'required|max:6',
            'area'          => 'required',
            'address'       => 'required|max:128',
            'phone'         => 'required|max:11',
            'title'         => 'required|max:20',
            'content'       => 'required|max:999',
            'time'          => 'required',
        ];
        $messages = [
            'name.required' => '称呼必填',
            'name.max'      => '称呼最大长度为6',
            'area.required'  => '必须选择地区',
            'address.required' => '必须填写详细地址',
            'address.max'      => '详细地址最大长度为128',
            'phone.required'    => '手机号必须填写',
            'phone.max'        => '手机号最大长度为11',
            'title.required'    => '必须填写标题',
            'title.max'        =>  '标题最大长度为20',
            'content.required' =>  '详细需求必须填写',
            'content.max'       => '详细需求最大长度为999',
            'time.required'     => '有效期必须选择',
        ];

        $validate = Validator::make($post,$rules,$messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        $area = explode(' ',$post['area']);
        $data = [
            'name' => $post['name'],
            'title' => $post['title'],
            'content' => $post['content'],
            'phone' => $post['phone'],
            'province' => $area[0] ?? '',
            'city'  => $area[1] ?? '',
            'area'  => $area[2] ?? '',
            'address' => $post['address'],
            'store_id' => $post['store_id'] ?? 0,
            'goods_id' => $post['goods_id'] ?? 0,
            'msg_price' => 59,
            'create_time' => time(),
        ];
        $data['validity_time'] = time() + (86400 * $post['time']);

        Message::insert($data);

        if ($data['store_id']) Store::increment('message_num');
        return ['code'=>1,'msg'=>'success'];
    }
}
