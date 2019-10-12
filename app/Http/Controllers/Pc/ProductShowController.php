<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\Attribute;
use App\Model\Index\Category;
use App\Model\Index\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductShowController extends BaseController
{
    public $page_type = 'productShow';

    public function index(Request $request)
    {
        $select_cate = $request->input('cate') ?? 0;
        $select_attr = $request->input('attr') ?? 0;

//        dd($select_cate);
        $cate = Category::get()->toArray();
        if ($select_cate){
            $attr = Attribute::where(['cate_id'=>$select_cate])->get()->toArray();
        }elseif ($cate){
            $attr = Attribute::where(['cate_id'=>$cate[0]['id']])->get()->toArray();
        }else{
            $attr = [];
        }

        $goods = Goods::where(function($query) use ($select_cate,$select_attr){
            if ($select_cate) $query->where(['cate_id'=>$select_cate]);
            if ($select_attr) $query->where(['attr_id'=>$select_attr]);
        })->where(['status'=>1])->orderBy('id','desc')->paginate(9);

        return view('pc.productShow.index',compact('cate','attr','goods','select_cate','select_attr'))->with(['page_type'=>$this->page_type,'config'=>$this->configObject]);
    }
}
