<?php

namespace App\Http\Middleware\Index;

use App\Model\Admin\UserBusiness;
use App\Model\Index\User;
use Closure;
use EasyWeChat\Factory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class AuthLoginCheck
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $except = ['index.pay.notify'];

        $routeName = request()->route()->getName();

        if (in_array($routeName,$except)) return $next($request);

        if (!in_array($routeName, $except) && !session('index.user_info')) {

            $app = Factory::officialAccount(config('wechat.official_account.default'));

            return $app->oauth->scopes(['snsapi_userinfo'])->redirect();
        }
        $userInfo = User::where(['id'=>Session::get('index.user_info')['id']])->first();
        //判断会员是否过期
        if (!Cache::has('check_'.$userInfo['openid'])){
            $update = [];
            if ($userInfo['vip_id']){
                $vipBusiness = UserBusiness::where(['user_id'=>$userInfo['id'],'type'=>1])->first();
                if (time() > $vipBusiness->length_of_time){
                    $update['vip_id'] = 0;
                    $userInfo->vip_id = 0;
                    UserBusiness::where(['user_id'=>$userInfo['id'],'type'=>1])->delete();
                }
            }
            if ($userInfo['store_service_id']){
                $StoreBusiness = UserBusiness::where(['user_id'=>$userInfo['id'],'type'=>2])->first();
                if (time() > $StoreBusiness->length_of_time){
                    $update['store_service_id'] = 0;
                    $userInfo->store_service_id = 0;
                    UserBusiness::where(['user_id'=>$userInfo['id'],'type'=>2])->delete();
                }
            }
            if ($update) User::where(['id'=>Session::get('index.user_info')['id']])->update($update);
            Cache::put('check_'.$userInfo['openid'],'1',now()->addHours(24));
        }

        $request->user_info = $userInfo;

        return $next($request);
    }
}
