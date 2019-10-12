<?php

namespace App\Http\Controllers\Pc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BaseController extends Controller
{
    public $configObject;
    const CONFIG_PATH = WEB_SITE_CONFIG_PATH;

    public function __construct()
    {
        $this->getConfig();
    }

    /**
     * 获取配置信息
     * @param $name
     * @return mixed|null
     */
    protected function getConfig($name = null)
    {
        if (!$this->configObject){
            $this->configObject = json_decode(file_get_contents(self::CONFIG_PATH));
        }
        if (!$name) return $this->configObject;
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
