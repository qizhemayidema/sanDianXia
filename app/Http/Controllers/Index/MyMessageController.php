<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\UserMessage as UserMessageModel;

class MyMessageController extends BaseController
{
    public function __construct()
    {
        $this->pageType = 'my_msg';
    }

    public function index(Request $request)
    {
        //查询我的商机
        $msg = UserMessageModel::join('message',function($query){
            $query->on('message.id','=','user_message.message_id');
        })->where(['user_message.user_id'=>$request->user_info->id])->where(['message.delete_time'=>0])->where(['message.status' => 2]);
        $search = $request->get('search') ?? $request->post('search') ?? '';
        if ($search){
            $msg = $msg->where('message.title','like',"%".$search."%");
        }
        $msg = $msg->select('message.*')->paginate(4);
        if ($request->isMethod('post')) {
            return ['code' => 1, 'data' => $msg, 'html' => view('index.my_message.index_list', compact('msg'))->toHtml()];
        }

        return view('index.my_message.index',compact('msg','search'))->with('page_type',$this->pageType);
    }
}
