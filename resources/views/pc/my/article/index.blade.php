@extends('pc.myBase.base')

@section('title') 我的文章 @endsection

@section('content')
    <div class="my_b_r_type my_b_r_type1">
        <span class="">我的文章</span>
    </div>
    <div class="w100">
        @if(!$data)
            <div class="zanwu">暂无数据</div>
        @endif
    </div>
    <div style="margin-top: 20px;">
        <div class="w100">
            <div id="collect_list_box">
                @foreach($data as $key => $value)
                    <div class="js_list oh bb1 abb_list">
                        <div class="js_list_img fl mr20">
                            <img src="{{ '/' . $value->pic }}" alt="">
                        </div>
                        <div class="js_info oh">
                            <div class="js_info_top oh mb20">
                                <h3 class="fz18 fw9 c3 mb10 oh1">{{ $value->title }}</h3>
                                <p class="fz14 c9" style="line-height: 23px;">
                                    {{ mb_substr($value->desc,0,150) }}
                                </p>
                            </div>
                            <div class="js_btn">
                                <button class="blue_btn" type="button" onclick="location.href='{{ route('pc.my.article.edit') }}?article_id='+{{ $value->id }}">编辑</button>
                                <button class="red_btn" type="button" onclick="del('{{$value->id}}')">删除</button>
                            </div>
                        </div>
                        <!-- </a> -->
                    </div>
                @endforeach
            </div>
            <div style="text-align: center">
                {{ $data->links() }}
            </div>

        </div>
    </div>
@endsection


@section('js')
    <script>
        var del = function(id){
            $.ajax({
                url:"{{ route('pc.my.article.delete') }}",
                type:'post',
                dataType:'json',
                data:{
                    id : id,
                    _token : "{{ csrf_token() }}",
                },
                success:function(data){
                    if (data.code == 0){
                        layer.msg(data.msg)
                    } else{
                        layer.msg('删除成功')
                        setTimeout(function () {
                            window.location.reload()
                        },1500)
                    }
                }
            })
        }
    </script>
@endsection