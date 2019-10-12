<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin\Attribute;
use App\Model\Admin\Category;
use App\Model\Admin\Message;
use App\Model\Admin\User;
use App\Model\Index\Goods;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CateController extends BaseController
{
    public function index()
    {
        $category = Category::orderBy('id', 'desc')->paginate(15);
        $attr = [];
        foreach ($category as $key => $value) {
            $attr[$value['id']] = Attribute::where('cate_id', $value['id'])->get()->toArray();
        }
        return view('admin.cate.index', compact('category', 'attr'));
    }

    public function add()
    {
        return view('admin.cate.add');
    }

    public function save(Request $request)
    {
        $post = $request->post();
        $rules = ['cate_name' => 'required|max:32', 'attr_values' => 'required'];
        $messages = [
            'cate_name.required' => '分类名称必须填写',
            'cate_name.max' => '分类名称最长为32',
            'attr_values.required' => '属性名称必须填写',
        ];
        $validate = Validator::make($post, $rules, $messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        //入库]
        DB::beginTransaction();
        try {
            (new Category())->id;
            $cate_id = Category::insertGetId(['name' => $post['cate_name']]);
            $attr_list = explode("\r\n", $post['attr_values']);
            $attr_res = [];
            foreach ($attr_list as $key => $value) {
                $attr_res[] = [
                    'cate_id' => $cate_id,
                    'attr_name' => $value,
                ];
            }
            Attribute::insert($attr_res);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return ['code' => 0, 'msg' => $e->getMessage()];
        }
        return ['code' => 1, 'msg' => 'success'];
    }

    public function edit($cate_id)
    {
        $cate_info = Category::find($cate_id);
        $attr_info = Attribute::where(['cate_id' => $cate_id])->get();

        return view('admin.cate.edit', compact('cate_info', 'attr_info'));
    }

    public function update($cate_id)
    {
        $post = request()->post();
        $rules = ['cate_name' => 'required|max:32'];
        $messages = [
            'cate_name.required' => '分类名称必须填写',
            'cate_name.max' => '分类名称最长为32',
        ];
        $validate = Validator::make($post, $rules, $messages);
        if ($validate->fails()) {
            return ['code' => 0, 'msg' => $validate->errors()->first()];
        }
        DB::beginTransaction();
        try{

            //修改的入库
            if (isset($post['attr_set'])){
                foreach ($post['attr_set'] as $key => $value){
                    Attribute::where(['id'=>$key])->update(['attr_name'=>$value]);
                }
            }

            //新增的入库
            if ($post['new_attr_value']){
                foreach (explode("\r\n", $post['new_attr_value']) as $key => $value) {
                    $attr_res[] = [
                        'cate_id' => $cate_id,
                        'attr_name' => $value,
                    ];
                }
                Attribute::insert($attr_res);
            }

            Category::where(['id'=>$cate_id])->update(['name'=>$post['cate_name']]);

            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            return ['code'=>0,'msg'=>$e->getMessage()];
        }

        return ['code' => 1, 'msg' => 'success'];
    }

    public function delete($cate_id)
    {
        $is_exists = Attribute::where(['cate_id'=>$cate_id])->first();
        if ($is_exists){
            return ['code'=>0,'msg'=>'分类下有属性,无法删除'];
        }
        Category::where(['id'=>$cate_id])->delete();
        return ['code'=>1,'msg'=>'success'];
    }

    public function deleteAttr(Request $request)
    {
        $attr_id = $request->post('attr_id');
        if (!$attr_id) return ['code' => 0, 'msg' => '操作失误'];

        //判断用户订阅中是否在使用
        $is_user = User::where(['attr_id' => $attr_id])->first();

        //判断发布的消息是否在使用
        $is_message = Message::where(['attr_id' => $attr_id])->first();

        //判断用户发布商品 是否选择了
        $is_goods = Goods::where(['attr_id'=>$attr_id])->first();

        if ($is_message || $is_user || $is_goods) {
            return ['code' => 0, 'msg' => '该属性正在使用,无法删除'];
        }
        Attribute::where(['id' => $attr_id])->delete();

        return ['code' => 1, 'msg' => 'success'];
    }
}
