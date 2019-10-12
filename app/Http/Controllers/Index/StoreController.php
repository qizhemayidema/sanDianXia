<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\Store as StoreModel;

class StoreController extends BaseController
{
    public function __construct()
    {
        $this->pageType = 'store';
    }

    public function index(Request $request)
    {
        $search = $request->get('search') ??  $request->post('search') ?? '';
        $store = StoreModel::where('end_time','>',time());
        if ($search) $store = $store->where('store_name','like','%'.$search.'%');
        $store = $store->paginate(15);
        if ($request->isMethod('post')) {
            return ['code' => 1, 'data' => $store, 'html' => view('index.store.index_list', compact('store'))->toHtml()];
        }
        return view('index.store.index',compact('store','search'))->with('page_type',$this->pageType);
    }
}
