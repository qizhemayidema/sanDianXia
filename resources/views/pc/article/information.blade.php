@extends('pc.base.base')

@section('title') 最新资讯 @endsection

@section('body')
    <div class="infoBanner" style="background-image: url({{ asset('static/pc/images/zx_02.jpg') }});">
    </div>
    <div class="w1200 oh">
        <div class="mb20"></div>
        <div class="w900 fl">
            <div class="copy_title">
                <div class="lm_tit oh"><i class="icon"></i>
                    <h3>最新资讯</h3>
                </div>
            </div>
            <!-- 6个 new_list-->
            <div class="new_list">
                @foreach($article as $key => $value)
                <a href="{{ route('pc.store.article',['article_id'=>$value->id]) }}" class="oh">
                    <img src="{{ '/' . $value->pic }}" alt="" class="new_img fl">
                    <div class="oh">
                        <div class="mb20"></div>
                        <h3 class="fz18 c3 fw9 mb10 oh1">{{ $value->title }}</h3>
                        <p class="fz14 lh20 c9">
                            {{ mb_substr($value->desc,0,100) }}
                        </p>
                    </div>
                </a>
                @endforeach
            </div>
            <div style="text-align: center">
                {{ $article->links() }}
            </div>
            <!--  -->
        </div>
        <!--  -->
        <div class="land_com_l fr">
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
                        <a href="{{ route('pc.store.article',['article_id'=>$value->id]) }}">
                            <img src="{{ '/' . $value->pic }}" alt="">
                            <p>{{ $value->title }}</p>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection