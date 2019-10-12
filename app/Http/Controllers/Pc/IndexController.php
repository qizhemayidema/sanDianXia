<?php

namespace App\Http\Controllers\Pc;

use App\Model\Admin\Image;
use App\Model\Index\Goods;
use App\Model\Index\Store;
use App\Model\Index\StoreArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    public $pageType = 'index';

    public function index()
    {
        $roll = Image::where(['type' => 1])->get();
        $network = Image::where(['type' => 2])->get();
        $store = Store::orderBy('message_num','desc')->limit(6)->get();
        $goods = Goods::where(['status'=>1])->orderBy('id','desc')->limit(6)->get()->toArray();
        $zixun = StoreArticle::where(['type'=>1,'status'=>1])->orderBy('id','desc')->limit(6)->get()->toArray();

        return view('pc.index.index', compact('roll', 'network','store','goods','zixun'))
            ->with(['config' => $this->configObject, 'page_type' => $this->pageType]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search') ?? '';


        $goods = Goods::where('title','like','%'.$search.'%')->where(['status'=>1])->orderBy('id','desc')->paginate(9);

        return view('pc.index.search',compact('goods','search'))->with(['page_type'=>'','config'=>$this->configObject]);

    }


}
