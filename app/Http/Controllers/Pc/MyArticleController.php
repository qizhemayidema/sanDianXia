<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\StoreArticle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class MyArticleController extends BaseController
{
    public $my_type = 'article';

    public $page_type = '';

    public function index()
    {
        $data = StoreArticle::where(['store_id'=>Session::get('pc')->id])
            ->where(['status'=>1])->orderBy('id','desc')->paginate(15);

        return view('pc.my.article.index',compact('data'))
            ->with([
                'my_type'=>$this->my_type,
                'page_type'=>$this->page_type,
                'config' => $this->configObject
            ]);
    }

    public function add()
    {
        $this->my_type = 'addArticle';
        return view('pc.my.article.add')
            ->with([
            'my_type'=>$this->my_type,
            'page_type'=>$this->page_type,
            'config' => $this->configObject
        ]);
    }

    public function save(Request $request)
    {
        $data = $request->post();
        $rules = [
            'type'  => 'required',
            'desc'  => 'required',
            'title' => 'required|max:20',
        ];
        $messages = [
            'type.required' => '类型必须选择',
            'desc.required' => '详情必须填写',
            'title.required' => '标题必须填写',
            'title.max'     => '标题最多限制20个字',
        ];

        $validate = Validator::make($data,$rules,$messages);

        if ($validate->fails()){
            return ['code'=>0,'msg'=>$validate->errors()->first()];
        }

        $file = $request->file('pic');
        if (!$file) return ['code'=>0,'msg'=>'请上传封面图'];

        $result = [
            'title' => $data['title'],
            'desc'  => $data['desc'],
            'store_id' => Session::get('pc')->id,
            'type'  => $data['type'],
            'create_time' => time(),
        ];

        if($file->isValid()){
            $filename = $file->getClientOriginalName();//原文件名
            $ext = $file->getClientOriginalExtension();//文件拓展名

            if (!in_array($ext,['jpg','jpeg','gif','png'])){
                return ['code'=>0,'msg'=>'图片格式不正确'];
            }
            if ($file->getSize() / 1024 / 1024 > 3){
                return ['code'=>0,'msg'=>'封面图不得超过3mb大小'];
            }

            $type = $file->getClientMimeType();//mimetype
            $path = $file->getRealPath();//绝对路径

            $result['pic'] = $file->store('upload');
        }else{
            return ['code'=>0,'msg'=>'封面上传失败'];
        }

        StoreArticle::insert($result);

        return ['code'=>1,'msg'=>'success'];

    }

    public function edit(Request $request){
        $article_id = $request->get('article_id');
        $data = StoreArticle::where(['store_id'=>Session::get('pc')->id])
            ->where(['id'=>$article_id])->first();
        return view('pc.my.article.edit',compact('data'))
            ->with([
                'my_type'=>$this->my_type,
                'page_type'=>$this->page_type,
                'config' => $this->configObject
            ]);

    }

    public function update(Request $request)
    {
        $data = $request->post();
        $rules = [
            'id'    => 'required',
            'type'  => 'required',
            'desc'  => 'required',
            'title' => 'required|max:20',
        ];
        $messages = [
            'type.required' => '类型必须选择',
            'desc.required' => '详情必须填写',
            'title.required' => '标题必须填写',
            'title.max'     => '标题最多限制20个字',
        ];

        $validate = Validator::make($data,$rules,$messages);

        if ($validate->fails()){
            return ['code'=>0,'msg'=>$validate->errors()->first()];
        }

        $file = $request->file('pic');

        $result = [
            'title' => $data['title'],
            'desc'  => $data['desc'],
            'type'  => $data['type'],
        ];

        if($file && $file->isValid()){
            $filename = $file->getClientOriginalName();//原文件名
            $ext = $file->getClientOriginalExtension();//文件拓展名

            if (!in_array($ext,['jpg','jpeg','gif','png'])){
                return ['code'=>0,'msg'=>'图片格式不正确'];
            }
            if ($file->getSize() / 1024 / 1024 > 3){
                return ['code'=>0,'msg'=>'封面图不得超过3mb大小'];
            }

            $type = $file->getClientMimeType();//mimetype
            $path = $file->getRealPath();//绝对路径

            $result['pic'] = $file->store('upload');
        }

        StoreArticle::where(['store_id'=>Session::get('pc')->id])
            ->where(['id'=>$data['id']])->update($result);

        return ['code'=>1,'msg'=>'success'];

    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        StoreArticle::where(['store_id'=>Session::get('pc')->id])
            ->where(['id'=>$id])->delete();

        return ['code'=>1,'msg'=>'success'];
    }
}
