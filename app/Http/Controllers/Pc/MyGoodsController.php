<?php

namespace App\Http\Controllers\Pc;

use App\Model\Index\Attribute;
use App\Model\Index\Category;
use App\Model\Index\Goods;
use App\Model\Index\StoreCate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MyGoodsController extends BaseController
{
    public $my_type = 'addGoods';

    public $page_type = '';

    public function index()
    {
        $this->my_type = 'goods';

        $data = Goods::where(['store_id'=>Session::get('pc')->id])
            ->where(['status'=>1])->orderBy('id','desc')->paginate(15);


        return view('pc.my.goods.index',compact('data'))
            ->with([
                'my_type'=>$this->my_type,
                'page_type'=>$this->page_type,
                'config' => $this->configObject
            ]);
    }

    public function add()
    {
        $this->my_type = 'addGoods';
        //查询官方分类
        $cate = Category::get()->toArray();
        $attr = $cate ? Attribute::where(['cate_id'=>$cate[0]['id']])->get()->toArray() : [];


        //查询本店的分类
        $local_cate = StoreCate::where(['store_id'=>Session::get('pc')->id])->get();

        return view('pc.my.goods.add',compact('cate','attr','local_cate'))
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
            'title'     => 'required|max:30',
            'cate_id'   => 'required',
            'attr_id'   => 'required',
            'store_cate_id' => 'required',
            'roll_pic'  => 'required',
            'sku_desc'  => 'required',
            'desc'      => 'required',
        ];

        $message = [
            'title.required' => '标题必须填写',
            'title.max'      => '标题最长30个字',
            'cate_id.required' => '官方分类必须选择',
            'attr_id.required' => '官方所属必须选择',
            'store_cate_id.required' => '本店分类必须选择',
            'roll_pic.required' => '轮播图必须上传',
            'sku_desc.required' => '规格介绍必须填写',
            'desc.required'    => '产品描述必须填写',
        ];

        $validate = Validator::make($data,$rules,$message);
        if ($validate->fails()){
            return ['code'=>0,'msg'=>$validate->errors()->first()];
        }

        $file = $request->file('pic');
        if (!$file) return ['code'=>0,'msg'=>'请上传封面图'];

        $result = [
            'store_id' => Session::get('pc')->id,
            'cate_id'   => $data['cate_id'],
            'attr_id'   => $data['attr_id'],
            'store_cate_id' => $data['store_cate_id'],
            'title'     => $data['title'],
            'roll_pic'  => $data['roll_pic'],
            'sku_desc'  => $data['sku_desc'],
            'desc'      => $data['desc'],
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

        Goods::insert($result);
        return ['code'=>1,'msg'=>'success'];

    }


    public function getAttr(Request $request)
    {
        $cate_id = $request->post('cate_id');
        return ['code'=>1,'data'=>Attribute::where(['cate_id'=>$cate_id])->get()];
    }


    public function edit(Request $request)
    {
        $goods_id = $request->get('goods_id');

        $data = Goods::where(['id'=>$goods_id,'store_id'=>Session::get('pc')->id])->first();

        $this->my_type = 'addGoods';
        //查询官方分类
        $cate = Category::get()->toArray();
        $attr = $cate ? Attribute::where(['cate_id'=>$data->cate_id])->get()->toArray() : [];


        //查询本店的分类
        $local_cate = StoreCate::where(['store_id'=>Session::get('pc')->id])->get();


        $this->my_type = 'goods' ;

        return view('pc.my.goods.edit',compact('data','cate','attr','local_cate'))
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
            'id'        => 'required',
            'title'     => 'required|max:30',
            'cate_id'   => 'required',
            'attr_id'   => 'required',
            'store_cate_id' => 'required',
            'roll_pic'  => 'required',
            'sku_desc'  => 'required',
            'desc'      => 'required',
        ];

        $message = [
            'title.required' => '标题必须填写',
            'title.max'      => '标题最长30个字',
            'cate_id.required' => '官方分类必须选择',
            'attr_id.required' => '官方所属必须选择',
            'store_cate_id.required' => '本店分类必须选择',
            'roll_pic.required' => '轮播图必须上传',
            'sku_desc.required' => '规格介绍必须填写',
            'desc.required'    => '产品描述必须填写',
        ];

        $validate = Validator::make($data,$rules,$message);
        if ($validate->fails()){
            return ['code'=>0,'msg'=>$validate->errors()->first()];
        }

        $file = $request->file('pic');


        $result = [
            'cate_id'   => $data['cate_id'],
            'attr_id'   => $data['attr_id'],
            'store_cate_id' => $data['store_cate_id'],
            'title'     => $data['title'],
            'roll_pic'  => $data['roll_pic'],
            'sku_desc'  => $data['sku_desc'],
            'desc'      => $data['desc'],
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

        Goods::where(['store_id'=>Session::get('pc')->id,'id'=>$data['id']])
            ->update($result);
        return ['code'=>1,'msg'=>'success'];

    }

    public function delete(Request $request)
    {
        $id = $request->post('id');
        Goods::where(['store_id'=>Session::get('pc')->id])
            ->where(['id'=>$id])->delete();

        return ['code'=>1,'msg'=>'success'];
    }
}
