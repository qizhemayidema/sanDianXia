<?php

namespace App\Http\Controllers\Pc;

use App\Model\Admin\StoreService;
use App\Model\Index\Goods;
use App\Model\Index\StoreCate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class MyCateController extends BaseController
{
    public $my_type = 'cate';
    public $page_type = '';

    public function index()
    {
        $store_id = Session::get('pc')->id;

        $data = StoreCate::where(['store_id'=>$store_id])->orderBy('id','desc')
            ->get();

        return view('pc.my.cate',compact('data'))->with([
                'my_type'=>$this->my_type,
                'page_type'=>$this->page_type,
                'config' => $this->configObject
            ]);
    }

    public function save(Request $request)
    {
        $cate = $request->post('cate');

        if (!$cate) return ['code'=>0,'msg'=>'名称必须填写'];

        if (mb_strlen($cate) > 15) return ['code'=>0,'msg'=>'名称最大长度为15'];

        $store_id = Session::get('pc')->id;

        $count = StoreCate::where(['store_id'=>$store_id])->count();

        if ($count >= 20) return ['code'=>0,'msg'=>'分类最多只能有20个'];

        StoreCate::insert(['store_id'=>$store_id,'name'=>$cate]);

        return ['code'=>1,'msg'=>'success'];

    }

    public function update(Request $request)
    {
        $cate_id = $request->post('cate_id');

        $cate = $request->post('cate');

        if (!$cate) return ['code'=>0,'msg'=>'名称必须填写'];

        if (mb_strlen($cate) > 15) return ['code'=>0,'msg'=>'名称最大长度为15'];

        $store_id = Session::get('pc')->id;

        $count = StoreCate::where(['store_id'=>$store_id])->count();

        if ($count >= 20) return ['code'=>0,'msg'=>'分类最多只能有20个'];

        StoreCate::where(['id'=>$cate_id,'store_id'=>$store_id])->update(['name'=>$cate]);

        return ['code'=>1,'msg'=>'success'];
    }

    public function changeStatus(Request $request)
    {

        $cate_id = $request->post('cate_id');

        $status = $request->post('status');

        $store_id = Session::get('pc')->id;


        StoreCate::where(['id'=>$cate_id,'store_id'=>$store_id])
            ->update(['is_banner'=>$status]);

        return ['code'=>1,'msg'=>'success'];

    }

    public function delete(Request $request)
    {
        $cate_id = $request->post('cate_id');


        $store_id = Session::get('pc')->id;

        if (Goods::where(['store_cate_id'=>$cate_id])->first()){
            return ['code'=>0,'msg'=>'此分类下有商品,无法删除'];
        }

        StoreCate::where(['id'=>$cate_id,'store_id'=>$store_id])
            ->delete();

        return ['code'=>1,'msg'=>'success'];
    }
}
