<?php

namespace App\Http\Controllers\Pc;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Index\StoreService;

class RzController extends BaseController
{
    public $pageType = 'rz';

    public function index()
    {
        $service = StoreService::orderBy('money')->first();

        return view('pc.rz.index',compact('service'))->with(['page_type'=>$this->pageType,'config'=>$this->configObject]);
    }
}
