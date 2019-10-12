<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\Message as MessageModel;
use App\Model\Index\UserMessage as UserMessageModel;
use Illuminate\Support\Facades\DB;

class IndexController extends BaseController
{
    public function __construct()
    {
        $this->pageType = 'index';
    }

    public function index(Request $request)
    {
        //接收搜索关键字
        $search = $request->get('search') ?? $request->post('search') ?? '';
        //查询商机
        $message = MessageModel::where('validity_time', '>', time())
            ->where(['delete_time' => 0])->where(['status' => 2]);
        if ($search) {
            $message = $message->where('title', 'like', '%' . $search . '%');
        }
        $message = $message->where(function ($query) {
            if (\request()->user_info->attr_id) {
                $query->where(['attr_id' => \request()->user_info->attr_id]);
            }
        })->orderBy('id', 'desc')->paginate(15);
        if ($request->isMethod('post')) {
            return ['code' => 1, 'data' => $message, 'html' => view('index.index.index_list', compact('message'))->toHtml()];
        }
        return view('index.index.index', compact('message', 'search'))->with('page_type', $this->pageType);
    }

    public function info($msg_id)
    {
        $data = MessageModel::where(['id' => $msg_id])->first();
        $dataPhone = $data['phone'];
        $data['phone'] = mb_substr($dataPhone, 0, 3) . '********';
//        接收本单人员
        $userhy = UserMessageModel::join('user', function ($query) {
            $query->on('user.id', '=', 'user_message.user_id');
        })->join('message', function ($query) {
            $query->on('message.id', '=', 'user_message.message_id');
        })->orderBy('user_message.id', 'desc')
            ->where(['user_message.message_id' => $msg_id])
            ->select('user.id as user_id', 'user.real_name', 'user_message.create_time', 'user_message.num')
            ->get();
        foreach ($userhy as $key => $value) {
            if ($value['user_id'] == \request()->user_info['id']) {
                $data['phone'] = $dataPhone;
                break;
            }
        }

        //最新单
        $new = MessageModel::where('validity_time', '>', time())
            ->where(['delete_time' => 0])->where(['status' => 2])
            ->where(function ($query) {
                if (\request()->user_info['attr_id']) {
                    $query->where(['attr_id' => \request()->user_info['attr_id']]);
                }
            })->orderBy('id', 'desc')->limit(3)->get();

        return view('index.index.info', compact('userhy', 'data', 'new'))->with('page_type', $this->pageType);
    }
}
