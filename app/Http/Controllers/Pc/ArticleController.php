<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\StoreArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends BaseController
{
    public $pageType;

    /**
     * 资讯
     */
    public function information()
    {
        $article = StoreArticle::where(['status'=>1])->where(['type'=>1])->orderBy('id','desc')->paginate(15);
        $hot =StoreArticle::where(['status'=>1])->where(['type'=>1])->orderBy('click','desc')->limit(6)->get();

        $this->pageType = 'information';
        return view('pc.article.information',compact('article','hot'))
            ->with(['page_type'=>$this->pageType,'config'=>$this->configObject]);

    }

    /**
     * 问题
     */
    public function question()
    {
        $article = StoreArticle::where(['status'=>1])->where(['type'=>2])->orderBy('id','desc')->paginate(15);
        $hot =StoreArticle::where(['status'=>1])->where(['type'=>2])->orderBy('click','desc')->limit(6)->get();

        $this->pageType = 'question';
        return view('pc.article.question',compact('article','hot'))
            ->with(['page_type'=>$this->pageType,'config'=>$this->configObject]);
    }


}
