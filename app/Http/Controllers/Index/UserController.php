<?php

namespace App\Http\Controllers\Index;

use App\Model\Index\Store;
use Illuminate\Http\Request;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;
use App\Model\Index\User as UserModel;
use App\Model\Index\Vip as VipModel;
use App\Model\Index\StoreService as StoreServiceModel;
use App\Model\Index\UserMoneyHistory as HistoryModel;
use App\Model\Index\Feedback as FeedbackModel;
use App\Model\Admin\UserBusiness as BusinessModel;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use Illuminate\Support\Facades\Validator;


class UserController extends BaseController
{

    public function __construct()
    {
        $this->pageType = 'user';
    }

    public function index(Request $request)
    {
//        $app->customer_service->create('xia@kefu', '客服');

//        //查询首充比例
        $first_pay = config('app.first_pay');
        $user_info = $request->user_info;
//        dd($user_info->pay_money);
        return view('index.user.index',compact('first_pay','user_info'))
            ->with('page_type',$this->pageType);
    }

    public function service(Request $request)
    {
        //获取会员服务
        $vip = VipModel::orderBy('money','desc')->get();

        $userVip = [];
        if ($request->user_info->vip_id){
            foreach ($vip as $key => $value){
                if ($value->id == $request->user_info->vip_id){
                    $userVip = $value->toArray();
                }
            }
        }

        //获取店铺服务
        $store = StoreServiceModel::orderBy('money','desc')->get();
        return view('index.user.service',compact('vip','store','userVip'));
    }

    public function history(Request $request)
    {
        $history = HistoryModel::where(['user_id'=>$request->user_info->id])->orderBy('id','desc')->paginate(7);

        if ($request->isMethod('post')){
            return ['code'=>1,'data'=>$history,'html'=>view('index.user.history',compact('history'))->toHtml()];
        }
        return view('index.user.history',compact('history'));
    }

    public function myService(Request $request)
    {
        $vipBusin = BusinessModel::where(['user_id'=>$request->user_info->id])
            ->where('length_of_time','>',time())
            ->where('type','=','1')
            ->first();
        $serviceBusin = BusinessModel::where(['user_id'=>$request->user_info->id])
            ->where('length_of_time','>',time())
            ->where('type','=','2')
            ->first();

        $vip = $vipBusin ? VipModel::where(['id'=>$vipBusin->business_id])->first() : [];
        $service = $serviceBusin ? StoreServiceModel::where(['id'=>$serviceBusin->business_id])->first() : [];
        //查询用户服务账号密码
        $store = $service ? Store::where(['user_id'=>$request->user_info->id])->first()->toArray() : [];

        return view('index.user.my_service',compact('vip','service','store'));
    }

    public function userInfo(Request $request)
    {
        $user_info = $request->user_info;
        $user_info->sub_area = explode(',',$user_info->sub_area);

        $sub_area = $this->getConfig('subArea');
        return view('index.user.info',compact('user_info','sub_area'));
    }

    public function editUserInfo(Request $request)
    {
        $user = $request->user_info;
        return view('index.user.edit_info',compact('user'));
    }

    public function updateUserInfo(Request $request)
    {
        $data = $request->post();
        $rules = [
            'real_name' => 'max:6',
            'phone'     => 'max:11',
            'profession' => 'max:10',
        ];
        $message = [
            'real_name.max' => '真实姓名最多六个字',
            'phone.max'     => '手机号长度不合法',
            'profession.max' => '销售品牌最大长度10个字',
        ];

        $validate = Validator::make($data,$rules,$message);
        if ($validate->fails()){
            return ['code'=>0,'msg'=>$validate->errors()->first()];
        }
        //如果手机号和不同则验证 手机验证码
        if ($data['phone'] != $request->user_info->phone){
            $code = Cache::get($data['phone']);
            if (!$data['phone_code'] || $code != $data['phone_code']){
                return ['code'=>0,'msg'=>'验证码不正确'];
            }
        }
        UserModel::where(['id'=>$request->user_info->id])->update([
            'phone' => $data['phone'],
            'real_name' => $data['real_name'],
            'profession' => $data['profession'],
        ]);
        return ['code'=>1,'msg'=>'success'];
    }

    public function feedback()
    {
        return view('index.user.feedback');
    }

    public function about()
    {
        $about = $this->getConfig('aboutOur');

        return view('index.user.about',compact('about'));
    }

    public function saveFeedback(Request $request)
    {
        $content = $request->post('content');
        if (!$content) return ['code'=>0,'msg'=>'内容不能为空'];
        if (mb_strlen($content) > 999) return ['code'=>0,'msg'=>'内容长度不能超过999'];

        $data = [
            'user_id' => $request->user_info->id,
            'content' => $content,
            'create_time' => time(),
        ];
        FeedbackModel::insert($data);
        return ['code'=>1,'msg'=>'success'];
    }

    public function changeUserSubArea(Request $request)
    {
        $area = $request->post('area');
        $flag = true;
        $user_info = $request->user_info;
        $temp = explode(',',$user_info->sub_area);
        foreach (explode(',',$user_info->sub_area) as $key => $value){
            if ($area == $value){
                unset($temp[$key]);
                $flag = false;
                break;
            }
        }
        if ($flag) $temp[] = $area;
        UserModel::where(['id'=>$user_info->id])->update([
            'sub_area' => implode(',',$temp)
        ]);
        return ['code'=>1,'msg'=>'success','type'=>$flag];
    }

    public function changeUserSubStatus(Request $request)
    {
        $user_info = $request->user_info;
        $is_apply = $user_info->is_apply ? 0 : 1;
        UserModel::where(['id'=>$user_info->id])->update([
            'is_apply' => $is_apply
        ]);
        return ['code'=>1,'msg'=>'success','type'=>$is_apply];
    }

    public function getPhoneCode(Request $request)
    {
        $phone = $request->post('phone');

        if (!$phone) return ['code'=>0,'msg'=>'error1'];
        if (Cache::has($phone)){
            $after = Cache::get($phone)['timestamp'];
            if (time() - $after <= 60){
                return ['code'=>0,'msg'=>'短信已发信,请耐心等待'];
            }
        }
        $result = $this->sendPhoneMsg($phone);

        if ($result['status']){
            //记录发送时间 记录手机号
            Cache::put($phone,$result['code'],60);
            return ['code'=>1,'msg'=>'success'];
        }else{
            return ['code'=>0,'msg'=>'发送失败,请联系网站管理员'];
        }
    }

    /**
     * 发送短信
     * @param $phone
     * @return array
     * @throws ClientException
     */
    protected function sendPhoneMsg($phone)
    {
        $code = mt_rand(1000,9999);
        $access_key_id = env('SMS_ACCESS_KEY_ID');
        $access_key_secret = env('SMS_ACCESS_KEY_SECRET');
        $sign_name = env('SMS_SIGN_NAME');
        $template_code = env('SMS_TEMPLATE_CODE');
        AlibabaCloud::accessKeyClient($access_key_id, $access_key_secret)->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->regionId('cn-beijing')
                // ->scheme('https') // https | http
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'PhoneNumbers'  => $phone,
                        'SignName'  => $sign_name,
                        'TemplateCode'  => $template_code,
                        'TemplateParam' => json_encode(['code'=>$code]),
                    ],
                ])
                ->request();
            return ['status'=>1,'data'=>$result->toArray(),'code'=>$code];
        } catch (ClientException $e) {
//            echo $e->getErrorMessage() . PHP_EOL;
            return ['status'=>0,'msg'=>$e->getErrorMessage()];
        } catch (ServerException $e) {
            return ['status'=>0,'msg'=>$e->getErrorMessage()];
        }
    }


    /**
     * 获取授权后的回调
     */
    public function callBack()
    {
        $app = Factory::officialAccount(config('wechat.official_account.default'));
        $oauth = $app->oauth;
        $user_info = $oauth->user()->toArray();
        if ($user_info){
            $data = [
                'nickname'  => $user_info['nickname'],
                'avatar_url'=> $user_info['avatar'],
                'openid'   => $user_info['original']['openid'],
                'sex'       => $user_info['original']['sex'],
                'city'      => $user_info['original']['city'],
                'province'  => $user_info['original']['province'],
                'country'   => $user_info['original']['country'],
            ];
            if (UserModel::where(['openid'=>$user_info['original']['openid']])->first()){
                UserModel::where(['openid'=>$user_info['original']['openid']])->update($data);
            }else{
                $data['create_time'] = time();
                UserModel::insert($data);
            }
            $user_info = UserModel::where(['openid'=>$data['openid']])->first();
            Session::put('index.user_info',$user_info);
            return redirect()->route('index.index');
        }
    }
}
