@extends('pc.base.base')

@section('body')
    <style>
        body{
            background-color: #eee;
        }
    </style>
    <div class="mb30"></div>
    <div class="w1200 oh">
        <div class="mybox_H">
            <div class="mybox_H_inr">管理中心</div>
        </div>
        <div class="w100 bgf mybox_B">
            <div class="mybox_L">
                <a href="{{ route('pc.my.cate') }}"><div class=" mybox_L_div @if($my_type == 'cate') cur @endif">分类管理</div></a>
                <a href="{{ route('pc.my.goods.add') }}"><div class=" mybox_L_div @if($my_type == 'addGoods') cur @endif">产品发布</div></a>
                <a href="{{ route('pc.my.goods') }}"><div class=" mybox_L_div @if($my_type == 'goods') cur @endif">我的产品</div></a>
                <a href="{{ route('pc.my.article.add') }}"><div class=" mybox_L_div @if($my_type == 'addArticle') cur @endif">发布文章</div></a>
                <a href="{{ route('pc.my.article') }}"><div class=" mybox_L_div @if($my_type == 'article') cur @endif">我的文章</div></a>
                <a href="{{ route('pc.my.info') }}"><div class=" mybox_L_div @if($my_type == 'info') cur @endif">信息设置</div></a>
            </div>
            <div class="mybox_R">
                @yield('content')
            </div>
        </div>
    </div>
    <div class="mb30"></div>
    <div class="mb30"></div>

@endsection