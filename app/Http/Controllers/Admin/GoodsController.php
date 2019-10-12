<?php

namespace App\Http\Controllers\Admin;

use App\Model\Index\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GoodsController extends BaseController
{
    public function index()
    {
//        $data =
//        DB::table('goods')->join('','')
        $data = Goods::join('category','category.id','goods.cate_id')
            ->join('attribute','attribute.id','goods.attr_id')
            ->orderBy('goods.id','desc')
            ->select('category.name as cate_name','attribute.attr_name','goods.*')
            ->paginate(15);

        return view('admin.goods.index',compact('data'));
    }


    public function check(Request $request)
    {
        $article_id = $request->post('goods_id');
        $info = Goods::where(['id'=>$article_id])->first();
        $status = $info->status ? 0 : 1;
        Goods::where(['id'=>$article_id])->update(['status'=>$status]);
        return ['code'=>1,'msg'=>'success'];
    }
}
