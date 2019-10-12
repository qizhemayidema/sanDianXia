<?php

namespace App\Http\Controllers\Index;

use App\Model\Index\UserMoneyHistory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\User as UserModel;
use Illuminate\Support\Facades\Session;
use App\Model\Index\UserMessage as UserMessageModel;


class BaseController extends Controller
{
    public $pageType;   //页面类型 用于判断选中状态

    public $configObject = null;

    const CONFIG_PATH = WEB_SITE_CONFIG_PATH;


    protected function addUserMessageHistory($user_id, $msg_id, $num)
    {
        $flag = UserMessageModel::where(['user_id' => $user_id, 'message_id' => $msg_id])->first();
        if ($flag) {
            UserMessageModel::where(['user_id' => $user_id, 'message_id' => $msg_id])
                ->update(['num' => $flag['num'] + $num]);
        } else {
            UserMessageModel::insert([
                'user_id' => $user_id,
                'message_id' => $msg_id,
                'num' => $num,
                'create_time' => time(),
            ]);
        }
    }

    public function addUserMoneyHistory($type, $money, $user_id = null)
    {
        $user_id = $user_id ?? request()->user_info->id;
        UserMoneyHistory::insert(['type' => $type, 'money' => $money, 'user_id' => $user_id, 'create_time' => time()]);
    }

    /**
     * 获取配置信息
     * @param $name
     * @return mixed|null
     */
    protected function getConfig($name)
    {
        if (!$this->configObject){
            $this->configObject = json_decode(file_get_contents(self::CONFIG_PATH));
        }
        $configPath = explode('.', $name);
        $temp = $this->configObject;
        try {
            foreach ($configPath as $key => $value) {
                $temp = $temp->$value;
            }
        } catch (\Exception $e) {
            header('Content-type: application/json');
            exit(json_encode(['code' => 0, 'msg' => '获取配置失败'], 256));
        }
        $temp = json_decode(json_encode($temp,256),true);
        return $temp;
    }
}
