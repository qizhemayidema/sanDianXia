@extends('pc.base.storeBase')

@section('source')
    <link rel="stylesheet" href="{{ asset('static/pc/css/jcarousel.connected-carousels.css') }}">
    <script href="{{ asset('static/pc/js/jquery.jcarousel.min.js') }}"></script>
    <script href="{{ asset('static/pc/js/jcarousel.connected-carousels.js') }}"></script>
@endsection

@section('title') {{ $store->store_name }} @endsection

@section('body')
    <div class="top_banner">
        <img  style="height: 80px;" src="{{ '/' . $store->banner }}" alt="">
    </div>
    <div class="shop_nav ">
        <div class="w1200 oh">
            <a href="{{ route('pc.store.index',['store_id'=>$store->id]) }}" class="active">首页</a>
            @foreach($cateBanner as $key => $value)
                <a href="{{ route('pc.store.index',['store_id'=>$store->id]) }}?cate_id={{ $value->id }}">{{ $value->name }}</a>
            @endforeach
        </div>
    </div>
    <div class="w1200">
        <div class="oh bd1">
            <div class="p20 oh">
                <div class="wrapper fl">
                    <div class="connected-carousels">
                        <div class="stage">
                            <div class="carousel carousel-stage" data-jcarousel="true">
                                <ul style="left: 0px; top: 0px;">
                                    @foreach(explode(',',$goods_info->roll_pic) as $key => $value)
                                    <li><img src="{{ '/' . $value }}" width="394" height="230" alt=""></li>
                                    @endforeach
                                </ul>
                            </div>
                            <a href="#" class="prev prev-stage inactive" data-jcarouselcontrol="true"><span>‹</span></a>
                            <a href="#" class="next next-stage" data-jcarouselcontrol="true"><span>›</span></a>
                        </div>
                        <div class="navigation">
                            <a href="#" class="prev prev-navigation inactive" data-jcarouselcontrol="true">‹</a>
                            <a href="#" class="next next-navigation inactive" data-jcarouselcontrol="true">›</a>
                            <div class="carousel carousel-navigation" data-jcarousel="true">
                                <ul style="left: 0px; top: 0px;">
                                    @foreach(explode(',',$goods_info->roll_pic) as $key => $value)
                                    <li data-jcarouselcontrol="true" @if($key == 0) class="active" @endif><img src="{{ '/'.$value }}" width="50" height="50" alt=""></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="shop_info_fr fr">
                    <div class="fz18 c3 fw9 mb10">{{ $goods_info->title }}</div>
                    <div class="shop_info_list oh">
                        @foreach(explode("\r\n",$goods_info->sku_desc) as $key => $value)
                            {{ $value }}<br/>

                        @endforeach
                    </div>
                    <div class="zixun">
                        <a href="#table"><button type="button">立即咨询</button></a>
                    </div>
                </div>
            </div>
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
            <div class="shop_info c3 fz14 fw900">
                {{ $goods_info->desc }}
            </div>
        </div>
    </div>
@endsection