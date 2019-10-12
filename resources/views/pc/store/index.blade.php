@extends('pc.base.storeBase')

@section('title') {{ $store->store_name }} @endsection

@section('body')
    <div class="top_banner">
        <img  style="height: 80px;" src="{{ '/' . $store->banner }}" alt="">
    </div>
    <div class="shop_nav ">
        <div class="w1200 oh">
            <a href="{{ route('pc.store.index',['store_id'=>$store->id]) }}" @if(!$select_cate) class="active" @endif>首页</a>
            @foreach($cateBanner as $key => $value)
            <a @if($select_cate == $value->id) class="active" @endif href="{{ route('pc.store.index',['store_id'=>$store->id]) }}?cate_id={{ $value->id }}">{{ $value->name }}</a>
            @endforeach
        </div>
    </div>
    <div class="w1200 oh">
        <div class="land_com_l fl">
            <div class="land_com_nav fl">
                <div class="copy_title">
                    <div class="lm_tit oh"><i class="icon"></i>
                        <h3>产品中心</h3>
                    </div>
                </div>
                <div class="com_nav_list3">
                    <ul>
                        @foreach($cate as $key => $value)
                        <li><a href="{{ route('pc.store.index',['store_id'=>$store->id]) }}?cate_id={{ $value->id }}"><span class="icon-uniE90A"></span>{{ $value->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="copy_title">
                    <div class="lm_tit oh"><i class="icon"></i>
                        <h3>销售工程师</h3>
                    </div>
                </div>
                <div class="land_com_peop oh">
                    <ul>
                        <li class="oh">
                            <span class="pic fl mr10"><img src="{{ '/' . $store->logo }}"></span>
                            <div class="info fl">
                                <h3>{{ $store->contact }}</h3>
                                <p class="fz14 c9">累计接待<b class="red">{{ $store->message_num }}</b>人</p>
                                <div class="clear_h5"></div>
                                <p class="fz12 c3">{{ $store->area }}</p>
                                <p class="c3 fz12"><a href="" class="c3">{{ $store->business_scope }}</a></p>
                            </div>
                            <div class="clear_h5"></div>
                            <a href="javascript:;" class="btn" style="width:100%;"><i class="icon pho"></i>销售电话：{{ $store->phone }}</a>
                        </li>
                    </ul>
                </div>
                <!--  -->
                <div class="copy_title">
                    <div class="lm_tit oh"><i class="icon"></i>
                        <h3>热门推荐</h3>
                    </div>
                </div>
                <!--  -->
                <div class="left_tj_box mb20">
                    <div class="p10">
                        @foreach($hot as $key => $value)
                        <div class="left_tj_list">
                            <a href="{{ route('pc.store.goods',['goods_id'=>$value->id]) }}">
                                <img src="{{ '/' .$value->pic }}" alt="">
                                <p>{{ $value->title }}</p>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="fr w900">
            <div class="copy_title">
                <div class="lm_tit oh"><i class="icon"></i>
                    <h3>产品展示</h3>
                </div>
            </div>
            <div class="oh right_tj">
                <!-- 15个 left_tj_list -->
                @foreach($goods_list as $key => $value)
                <div class="left_tj_list fl">
                    <a href="{{ route('pc.store.goods',['goods_id'=>$value->id]) }}">
                        <img src="{{ '/' . $value->pic }}" alt="">
                        <p>{{ $value->title }}</p>
                    </a>
                </div>
                @endforeach

            </div>
            <div style="text-align: center;">
                {{ $goods_list->appends(['cate_id'=>$select_cate])->links() }}
            </div>
        </div>
    </div>
@endsection