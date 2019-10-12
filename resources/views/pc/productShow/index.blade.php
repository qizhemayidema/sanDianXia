@extends('pc.base.base')

@section('title') 产品展示 @endsection

@section('body')

    <div class="infoBanner" style="background-image: url({{ asset('static/pc/images/c_02.jpg') }});">
    </div>
    <div class="">
        <div class="bgf">
            <div class="w1200">
                <div class="p_class_box oh mb20">
                    @foreach($cate as $key => $value)
                    <a href="{{ route('pc.productShow.index') }}?cate={{ $value['id'] }}" class=" fl fz18 c3 fw9 @if($value['id'] == $select_cate) active @endif">{{ $value['name'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="w1200">
            <!--  -->
            <div class="box bgf mb20">
                <div class="p20 oh" style="padding-bottom: 10px;">
                    <div class="fl class_f fz14 c3 fw9">分类：</div>
                    <div class="fl oh class_list">
                        <a href="{{ route('pc.productShow.index') }}?cate={{ $select_cate }}"><p class="fl fz14 c6 fw9 @if(!$select_attr) active @endif">全部</p></a>
                    @foreach($attr as $key => $value)
                        <a href="{{ route('pc.productShow.index') }}?cate={{ $select_cate }}&attr={{ $value['id'] }}">
                            <p class="fl fz14 c6 fw9 @if($select_attr == $value['id']) active @endif">{{ $value['attr_name'] }}</p>
                        </a>
                    @endforeach
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="clear product" style="padding: 20px 0;">
                @foreach($goods as $key => $value)
                <a href="{{ route('pc.store.goods',['goods_id'=>$value->id]) }}" class="cp_list">
                    <img src="{{ '/' . $value->pic }}" alt="">
                    <p class="fz16 tac">{{ mb_substr($value->title,0,16) }}</p>
                </a>
                @endforeach
            </div>
            <!-- 分页用你原有的项目复制吧 -->
            <div style="text-align: center;">
                {{ $goods->appends(['cate'=>$select_cate,'attr'=>$select_attr])->links() }}
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        // banner
        $('.single-item').slick({
            dots: true,
            speed: 500,
            arrows: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000
        });
        $(".cp_list:nth-child(3n)").css({ 'margin-right': 0 });
        $(".class_list p").click(function() { //选择性别
            $(".class_list p").removeClass('active');
            $(this).addClass('active');
        });

    </script>
@endsection