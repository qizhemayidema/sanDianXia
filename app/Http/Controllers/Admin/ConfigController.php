<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends BaseController
{
    public function index()
    {
        $config = $this->getConfig();
        return view('admin.config.index',compact('config'));
    }

    public function save(Request $request)
    {
        $data = [
            'start_time' =>  $request->post('start_time'),
            'end_time' =>  $request->post('end_time'),
            'phone' =>  $request->post('phone'),
            'qrCode'  => $request->post('qrCode'),
            'icp'  => $request->post('icp'),
            'dianXin'  => $request->post('dianXin'),
            'aboutOur' => $request->post('aboutOur'),
            'subArea'  => $this->getConfig('subArea'),
        ];
        $data = json_encode($data);

        
        $status = file_put_contents(self::CONFIG_PATH, $data);

        return ['code'=>1,'msg'=>'success'];
    }
}
