<?php

namespace App\Http\Controllers\Admin;

use App\Model\Index\StoreArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends BaseController
{
    public function index(Request $request)
    {
        $type = $request->type ? $request->type : 1;
        $data = StoreArticle::where(['type'=>$type])->orderBy('id','desc')->paginate(15);

        return view('admin.article.index',compact('data'));
    }

    public function check(Request $request)
    {
        $article_id = $request->post('article_id');
        $info = StoreArticle::where(['id'=>$article_id])->first();
        $status = $info->status ? 0 : 1;
        StoreArticle::where(['id'=>$article_id])->update(['status'=>$status]);
        return ['code'=>1,'msg'=>'success'];
    }
}
