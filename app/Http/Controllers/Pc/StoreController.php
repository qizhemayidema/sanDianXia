<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\Goods;
use App\Model\Index\Store;
use App\Model\Index\StoreArticle;
use App\Model\Index\StoreCate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class StoreController extends BaseController
{
    public function index(Store $store_id,Request $request)
    {
        $cate_id = $request->input('cate_id') ?? 0;

        $cateBanner = StoreCate::where(['store_id'=>$store_id->id])
            ->where(['is_banner'=>1])
            ->get();

        $cate = StoreCate::where(['store_id'=>$store_id->id])->get();

        $hot = Goods::where(['store_id'=>$store_id->id])->orderBy('click')->limit(6)->get();

        $goods_list = Goods::where(function($query) use ($cate_id){
            if ($cate_id) $query->where(['store_cate_id'=>$cate_id]);
        })->where(['store_id'=>$store_id->id])->where(['status'=>1])
            ->paginate(15);

        return view('pc.store.index',compact('cateBanner','cate','hot','goods_list'))
            ->with(['config'=>$this->configObject,'store'=>$store_id,'select_cate'=>$cate_id]);
    }

    public function goods(Goods $goods_id,Request $request)
    {
        Goods::where(['id'=>$goods_id->id])->update(['click'=>$goods_id->click + 1]);

        $cateBanner = StoreCate::where(['store_id'=>$goods_id->store_id])
            ->where(['is_banner'=>1])
            ->get();

        $store = Store::where(['id'=>$goods_id->store_id])->first();
        $cate = StoreCate::where(['store_id'=>$goods_id->store_id])->get();

        $hot = Goods::where(['store_id'=>$goods_id->store_id])->orderBy('click')->limit(6)->get();

        return view('pc.store.goods',compact('cateBanner','cate','hot'))
            ->with(['config'=>$this->configObject,'store'=>$store,'goods_info'=>$goods_id]);

    }

    public function article(StoreArticle $article_id,Request $request)
    {
        StoreArticle::where(['id'=>$article_id->id])->update(['click'=>$article_id->click + 1]);

        $cateBanner = StoreCate::where(['store_id'=>$article_id->store_id])
            ->where(['is_banner'=>1])
            ->get();

        $store = Store::where(['id'=>$article_id->store_id])->first();
        $cate = StoreCate::where(['store_id'=>$article_id->store_id])->get();

        $hot = Goods::where(['store_id'=>$article_id->store_id])->orderBy('click')->limit(6)->get();

        return view('pc.store.article',compact('cateBanner','cate','hot'))
            ->with(['config'=>$this->configObject,'store'=>$store,'article'=>$article_id]);

    }
}
