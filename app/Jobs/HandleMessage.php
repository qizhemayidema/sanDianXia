<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use EasyWeChat\Factory;
use App\Model\Index\User as UserModel;


class HandleMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $vip;
    protected $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $message,array $vipInfo = [])
    {
        $this->message = $message;
        $this->vip = $vipInfo;
        $this->url = route('index.message.info',['msg_id'=>$this->message['id']]);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $app = Factory::officialAccount(config('wechat.official_account.default'));

        $customer = $app->customer_service;
        $content = "新询价单通知\r\n<a href='".$this->url."'>".$this->message['title']."</a>\r\n地区 : ".$this->message['province'].($this->message['city'] ? '/'.$this->message['city'] : '')."\r\n联系人 : ".$this->message['name']."\r\n联系方式 : ".mb_substr($this->message['phone'],0,3)."********\r\n时间 : ".date("Y-m-d H:i:s",$this->message['create_time'])."\r\n<a href='".$this->url."'>点击查看商机详情</a>";
        UserModel::where([
            'status'=>0,
            'is_apply'=>1,
            ])->where('sub_area','like','%'.$this->message['province'].'%')
            ->where(['vip_id'=>$this->vip['id'] ?? 0])
            ->where('attr_id','=',$this->message['attr_id'])
            ->orWhere('attr_id','=',0)
            ->chunk(500,function($users) use($customer,$content){
                foreach ($users as $user){
                    $customer->message($content)->to($user->openid)->send();
                }
            });
    }
}
