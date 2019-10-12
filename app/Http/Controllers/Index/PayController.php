<?php

namespace App\Http\Controllers\Index;

use App\Model\Index\User;
use App\Model\Index\UserMoneyHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use EasyWeChat\Payment\Kernel\BaseClient;
use EasyWeChat\Factory;
use App\Model\Index\Order as OrderModel;
use Illuminate\Support\Facades\DB;
use App\Model\Index\User as UserModel;
use App\Model\Index\Vip as VipModel;
use App\Model\Admin\UserBusiness as BusinessModel;
use App\Model\Index\StoreService as StoreServiceModel;
use App\Model\Index\Store as StoreModel;

class PayController extends BaseController
{
    /**
     * 在支付中使用的自定义字段中
     * type代表付款的对象类型 例如 充值 会员 店铺
     * status 代表 某个对象的不同付款原因 例如 续费 升级 选填写
     */

    /**
     * 购买vip
     * @param Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function payVip(Request $request)
    {
        //第一种 最普通的情况 普通用户 -> 开通会员  status 1
        //第二种 会员到会员   低级会员 -> 高级会员  status 2
        //第三种 会员到会员   高级会员 -> 低级会员  禁止
        //第四种 会员续费     会员  ->  续费       status 3
        //判断用户是否开通了此会员

        $userId = $request->user_info->id;

        $userVipId = $request->user_info->vip_id;

        $vipId = $request->post('vip_id');

        $vipInfo = VipModel::where(['id' => $vipId])->first();

        $pay_money = null;  //支付金额  单位元
        $status = 0;        //支付原因
        $order_title = '';

        //获取当前会员信息
        if ($userVipId) {
            $userVipInfo = VipModel::where(['id' => $userVipId])->first();
            if ($userVipId == $vipId) {   //续费
                $pay_money = $vipInfo['money'];
                $order_title = '续费会员';
                $status = 3;
            } else {
                if ($vipInfo['money'] < $userVipInfo['money']) {//降级
                    return ['code' => 0, 'msg' => '您已开通更高的会员'];
                }
                //升级   计算升级所需的金额,
                $otherMoney = $vipInfo['money'] - $userVipInfo['money'];//需要补上的总金额
                $userBusiness = BusinessModel::where(['user_id' => $userId, 'type' => 1])->first();

                $otherTime = ($userBusiness['length_of_time'] - time()) / 31536000;  //会员的剩余时间
                /**
                 * 规则 用要补上的价格差价乘以剩余时间
                 */
                $pay_money = floor($otherMoney * $otherTime);       //剩余付款的金额
                $status = 2;
                $order_title = '升级会员';

            }
        } else {      //新的会员
            $pay_money = $vipInfo['money'];
            $status = 1;
            $order_title = '开通会员';

        }
        return $this->makePay(2, $pay_money, $order_title, $status, $vipId);
    }

    /**
     * 购买店铺会员
     */
    public function payStoreService(Request $request)
    {
        $store_service_id = $request->post('service_id');
        /**
         * 两种情况 一种续费 一种开通
         */
        $serviceInfo = StoreServiceModel::where(['id' => $store_service_id])->first();

        $userInfo = $request->user_info;

        $type = 3;

        //判断是否为会员才可购买的业务
        if ($serviceInfo['vip_id'] != 0) {
            $userVip = VipModel::where(['id' => $userInfo['vip_id']])->first();
            $serviceVip = VipModel::where(['id' => $serviceInfo['vip_id']])->first();
            if ($userVip['money'] < $serviceVip['money']) {
                return ['code' => 0, 'msg' => '此服务只有' . $serviceVip['name'] . '会员(及以上)才可购买'];
            }
        }
        if ($userInfo['store_service_id'] != 0) {
            //续费 status 1
            $status = 1;
            $order_title = '续费 店铺服务';
        } else {
            //开通 status 2
            $status = 2;
            $order_title = '开通 店铺服务';
        }
        $pay_money = $serviceInfo['money'];
        return $this->makePay($type, $pay_money, $order_title, $status, $store_service_id);
    }

    /**
     * 充值账户余额
     * @param Request $request
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function payAccountMoney(Request $request)
    {
        $payMoney = $request->post('pay_money');
        if (!is_numeric($payMoney) && $payMoney <= 0)
            return ['code' => 0, 'msg' => '支付金额必须大于0且为整数'];
        //判断是否为首充
        $userPayMoney = $request->user_info->pay_money;   //用户充值总记录
        if (!$userPayMoney) {
            $title = '充值账户 + ' . $payMoney * (1 + config('app.first_pay')) . '元';
        } else {
            $title = '充值账户 + ' . $payMoney . '元';
        }
        $type = 1;

        return $this->makePay($type, $payMoney, $title);
    }


    /**
     * 创建jsapi支付所需参数
     * @param $type
     * @param $payMoney
     * @param $title
     * @param null $type_status
     * @param null $common_id
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function makePay($type, $payMoney, $title, $type_status = null, $common_id = null)
    {
        DB::beginTransaction();
        try {
            $orderCode = $this->makeOrder($type, $payMoney, $title, $type_status, $common_id);
            $payConfig = config('wechat.payment.default');
            $app = Factory::payment($payConfig);
            $jssdk = $app->jssdk;
            $result = $app->order->unify([
                'body' => $title,
                'out_trade_no' => $orderCode,
                'trade_type' => 'JSAPI',
//                'total_fee' => $payMoney * 100,//todo
                'total_fee' => 1,//todo
                'attach' => json_encode(['type' => $type, 'type_status' => $type_status], true),
                'notify_url' => route('index.pay.notify'),
                'openid' => request()->user_info->openid,
            ]);
            //预支付订单号prepayId, 生成支付 JS 配置
            $prepayId = $result['prepay_id'];
            $jsApiParameters = $jssdk->bridgeConfig($prepayId);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['code' => 0, '支付失败,请刷新后重试'];
        }
        return ['code' => 1, 'jsApiParameters' => $jsApiParameters];
    }

    /**
     * 回调入口
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \EasyWeChat\Kernel\Exceptions\Exception
     */
    public function notify()
    {
        $payConfig = config('wechat.payment.default');
        $app = Factory::payment($payConfig);
        $response = $app->handlePaidNotify(function ($message, $fail) {
            DB::beginTransaction();
            try{
                $message['attach'] = json_decode($message['attach'], true);

                $type = $message['attach']['type'];

                $orderCode = $message['out_trade_no'];

                $orderInfo = OrderModel::where(['type' => $type])->where(['order_code' => $orderCode])->first();

                $userId = $orderInfo->user_id;

                $userInfo = UserModel::where(['id' => $userId])->first();

                if (!$orderInfo || $orderInfo->status == 2) {
                    $fail('Order not exists.');
                } else {
                    $historyType = null;
                    switch ($type) {
                        case 1 :                //充值余额
                            //判断是否首充
                            if ($userInfo['pay_money'] == 0) {
                                $money = floor($orderInfo->pay_money * (1 + config('app.first_pay')));
                            } else {
                                $money = $orderInfo->pay_money;
                            }
                            UserModel::where(['id' => $userId])->update([
                                'pay_money' => $userInfo->pay_money + $orderInfo->pay_money,
                                'money' => $userInfo->money + $money,
                            ]);
                            $historyType = 4;   //历史记录类型
                            break;
                        case 2:                 //开通会员
                            //1 开通 2 升级 3 续费
                            $type_status = $message['attach']['type_status'];
                            if ($type_status == 1) {
                                BusinessModel::where(['user_id' => $userId, 'type' => 1])->delete();
                                BusinessModel::insert([
                                    'type' => 1,
                                    'user_id' => $userId,
                                    'business_id' => $orderInfo->common_id,
                                    'create_time' => time(),
                                    'length_of_time' => strtotime('+1year'),
                                ]);
                                UserModel::where(['id' => $userId])->update([
                                    'vip_id' => $orderInfo->common_id,
                                ]);
                            } elseif ($type_status == 2) {
                                BusinessModel::where(['user_id' => $userId, 'type' => 1])->update([
                                    'business_id' => $orderInfo->common_id,
                                ]);
                                UserModel::where(['id' => $userId])->update([
                                    'vip_id' => $orderInfo->common_id,
                                ]);
                            } elseif ($type_status == 3) {
                                $business = BusinessModel::where(['user_id' => $userId, 'type' => 1])->first();
                                BusinessModel::where(['user_id' => $userId, 'type' => 1])->update([
                                    'length_of_time' => $business->length_of_time + 31536000,
                                ]);
                            }
                            $historyType = 1;   //历史记录类型
                            break;
                        case 3:                 //开通店铺
                            //1 续费 2 开通
                            $type_status = $message['attach']['type_status'];
                            if ($type_status == 1) {
                                //business表
                                $business = BusinessModel::where(['user_id' => $userId, 'type' => 2])->first();
                                BusinessModel::where(['id' => $business->id])->update([
                                    'length_of_time' => $business->length_of_time + 31536000,
                                ]);
                                //store表
                                StoreModel::where(['user_id' => $userId])->update([
                                    'end_time' => $business->length_of_time + 31536000,
                                ]);
                            } elseif ($type_status == 2) {
                                //判断用户是否有store 如果没有则创建
                                $flag = StoreModel::where(['user_id' => $userId])->first();
                                $create_time = time();
                                $end_time = strtotime('+1year');
                                if (!$flag) {
                                    $insert = [
                                        'user_id' => $userId,
                                        'create_time' => $create_time,
                                        'end_time' => $end_time,
                                        'username' => uniqid(),
                                        'password' => md5(uniqid() . $userInfo->openid),
                                    ];
                                    $storeId = StoreModel::insertGetId($insert);
                                } else {
                                    $storeId = $flag->id;
                                }
                                //business
                                BusinessModel::where(['type' => 2, 'user_id' => $userId])->delete();
                                BusinessModel::insert([
                                    'type' => 2,
                                    'user_id' => $userId,
                                    'business_id' => $orderInfo->common_id,
                                    'create_time' => $create_time,
                                    'length_of_time' => $end_time,
                                ]);
                                //user
                                UserModel::where(['id' => $userId])->update(['store_service_id' => $storeId]);
                            }
                            $historyType = 2;   //历史记录类型
                            break;
                    }
                    //改变订单状态
                    OrderModel::where(['type' => $type])->where(['order_code' => $orderCode])
                        ->update(['status' => 2, 'pay_time' => time()]);
                    //记录变动历史记录
                    UserMoneyHistory::insert([
                        'type' => $historyType,
                        'user_id' => $userId,
                        'money' => $orderInfo->pay_money,
                        'create_time' => time(),
                    ]);
                    DB::commit();
                    return true;
                }
            }catch (\Exception $e){
                DB::rollBack();
                file_put_contents('./1.txt',$e->getMessage().$e->getLine());
            }
        });
        return $response;
    }

    /**
     * 生成订单
     * @param $type
     * @param $payMoney
     * @param $title
     * @param null $common_id
     * @return string
     */
    private function makeOrder($type, $payMoney, $title, $type_status = null, $common_id = null)
    {
        $orderCode = $this->createTransferCode();
        $data = [
            'order_code' => $orderCode,
            'user_id' => request()->user_info->id,
            'type' => $type,
            'pay_money' => $payMoney,
            'title' => $title,
            'create_time' => time(),
        ];
        if ($common_id) $data['common_id'] = $common_id;
        if ($type_status) $data['type_status'] = $type_status;
        OrderModel::insert($data);
        return $orderCode;
    }

    /**
     * 生成唯一订单号
     * @return string
     */
    private function createTransferCode()
    {
        $order_date = date('Y-m-d');

        //订单号码主体（YYYYMMDDHHIISSNNNNNNNN）

        $order_id_main = date('YmdHis') . rand(10000000, 99999999);

        //订单号码主体长度

        $order_id_len = mb_strlen($order_id_main);

        $order_id_sum = 0;

        for ($i = 0; $i < $order_id_len; $i++) {

            $order_id_sum += (int)(mb_substr($order_id_main, $i, 1));

        }

        //唯一订单号码（YYYYMMDDHHIISSNNNNNNNNCC）

        return $order_id_main . str_pad((100 - $order_id_sum % 100) % 100, 2, '0', STR_PAD_LEFT);
    }


}
