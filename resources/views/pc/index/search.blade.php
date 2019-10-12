@extends('pc.base.base')

@section('title') 搜索结果 @endsection

@section('search') {{ $search }} @endsection

@section('body')


    <div class="">

        <div class="w1200">
            <!--  -->
            <div class="box bgf mb20">
                关键字 : {{ $search }}
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
                {{ $goods->appends(['search'=>$search])->links() }}
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