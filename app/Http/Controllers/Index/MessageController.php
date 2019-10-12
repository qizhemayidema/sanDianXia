<?php

namespace App\Http\Controllers\Index;

use App\Model\Admin\Category;
use App\Model\Index\Attribute;
use App\Model\Index\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\Message as MessageModel;
use App\Model\Index\User as UserModel;
use App\Model\Index\UserMessage as UserMessageModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class MessageController extends BaseController
{
    //订阅商机页面
    public function subMsg(Request $request)
    {
        $cate = Category::get()->toArray();

        $userSelect = $request->user_info->attr_id ? Attribute::where(['id'=>$request->user_info->attr_id])->first()->toArray() : [];

        $cateId = $userSelect['cate_id'] ?? $cate[0]['id'] ?? 0;

        $attr = $cateId ? Attribute::where(['cate_id'=>$cateId])->get()->toArray() : [];


        return view('index.message.sub',compact('cate','attr','userSelect'))->with(['page_type'=>$this->pageType]);
    }

    public function getAttr(Request $request)
    {
        $cate_id = $request->post('cate_id');
        return ['code'=>1,'data'=>Attribute::where(['cate_id'=>$cate_id])->get()];
    }

    public function saveSelectAttr(Request $request)
    {
        $user_id = $request->user_info->id;
        $attr_id = $request->post('attr_id');
        if (!$attr_id) return ['code'=>0,'msg'=>'必须选择一个所属'];
        UserModel::where(['id'=>$user_id])->update(['attr_id'=>$attr_id]);
        return ['code'=>1,'msg'=>'success'];
    }

    //接单接口
    public function buy()
    {
        $msg_id = request()->post('msg_id');
        $type = request()->post('type');
        DB::beginTransaction();
        try{
            while(true){
                $msgInfo = MessageModel::where(['id'=>$msg_id])->first();
                $userInfo = UserModel::where(['id'=>Session::get('index.user_info.id')])->first();
                //判断消息是否满员
                if ($msgInfo['accept_sum'] == 4){
                    throw new \Exception('商机已被买断');
                }
                //判断用户账户余额
                if ($type == 'all'){
                    $pay_money = $msgInfo['msg_price'] * (4 - $msgInfo['accept_sum']);
                    if ($userInfo['money'] < $pay_money){
                        throw new \Exception('账户余额不足,请及时充值');
                    }
                    if ($msgInfo['validity_time'] < time()){
                        throw new \Exception('该商机已过期');
                    }
                    if ($msgInfo['status'] != 2){
                        throw new \Exception('该商机不存在');
                    }
                    if ($msgInfo['delete_time'] != 0){
                        throw new \Exception('该商机不存在');
                    }
                    if (!MessageModel::where(['id'=>$msg_id])
                        ->where(['version'=>$msgInfo['version']])->update(['accept_sum'=>4,'version'=>$msgInfo['version'] + 1])){
                        DB::rollBack();
                        continue;
                    }
                    if (!UserModel::where(['id'=>$userInfo['id']])
                        ->where(['version'=>$userInfo['version']])
                        ->update(['money'=>$userInfo['money'] - $pay_money,'version'=>$userInfo['version'] + 1])){
                        DB::rollBack();
                        continue;
                    }
                    $this->addUserMessageHistory($userInfo['id'],$msgInfo['id'],4 - $msgInfo['accept_sum']);
                    $this->addUserMoneyHistory(3,$pay_money);

                }elseif($type == 'one'){
                    $pay_money = $msgInfo['msg_price'];
                    if ($userInfo['money'] < $pay_money){
                        throw new \Exception('账户余额不足,请及时充值');
                    }
                    if ($msgInfo['validity_time'] < time()){
                        throw new \Exception('该商机已过期');
                    }
                    if ($msgInfo['status'] != 2){
                        throw new \Exception('该商机不存在');
                    }
                    if ($msgInfo['delete_time'] != 0){
                        throw new \Exception('该商机不存在');
                    }
                    if (!MessageModel::where(['id'=>$msg_id])
                        ->where(['version'=>$msgInfo['version']])->update(['accept_sum'=>$msgInfo['accept_sum'] + 1,'version'=>$msgInfo['version'] + 1])){
                        DB::rollBack();
                        continue;
                    }
                    if (!UserModel::where(['id'=>$userInfo['id']])
                        ->where(['version'=>$userInfo['version']])
                        ->update(['money'=>$userInfo['money'] - $pay_money,'version'=>$userInfo['version'] + 1])){
                        DB::rollBack();
                        continue;
                    }
                    $this->addUserMessageHistory($userInfo['id'],$msgInfo['id'],1);
                    $this->addUserMoneyHistory(3,$pay_money);
                }else{
                    return ['code'=>0,'msg'=>'请刷新页面后重新操作'];
                }
                DB::commit();
                return ['code'=>1,'msg'=>'success'];
            }
        }catch (\Exception $e){
            DB::rollBack();
            return ['code'=>0,'msg'=>$e->getMessage()];
        }
    }
}
