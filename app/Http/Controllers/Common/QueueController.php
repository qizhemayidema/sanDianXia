<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use App\Jobs\HandleMessage;
use App\Model\Admin\Vip;


class QueueController extends Controller
{
    public function publishMessageToSubscriberByWechatPublicNumber($msg)
    {
        $vipInfo = Vip::get();
        foreach ($vipInfo as $key => $value){
            HandleMessage::dispatch($msg,$value->toArray())->delay(now()->addSeconds($value->delay));
        }
        HandleMessage::dispatch($msg)->delay(now()->addSeconds(config('app.normal_user')));

    }
}
