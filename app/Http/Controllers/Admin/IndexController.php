<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends BaseController
{
    //框架
    public function index()
    {
        return view('admin.index.index');

    }

    //主页
    public function homePage()
    {
        return '';
    }
}
