@extends('index.common.base')

@section('body')
    <div class="weui-search-bar" id="searchBar">
        <div class="weui-search-bar__form">
            <div class="weui-search-bar__box">
                <i class="weui-icon-search"></i>
                <input type="search" value="{{ $search }}" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required="" onkeyup="keyup(event)">
                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
            </div>
            <label class="weui-search-bar__label" {{ $search }} id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                <i class="weui-icon-search"></i>
                <span>{{ $search ? $search : '搜索' }}</span>
            </label>
        </div>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
    </div>
    <!--  -->
    <!-- 首页列表 -->
    <div id="list_box" class="index_list_box myShangJi">
    @if(count($msg))
            @foreach($msg as $key => $value)
                <a href="{{ route('index.message.info',['msg_id'=>$value->id]) }}" class="index_list mb10 bgf">
                    <div class="flex index_list_title">
                        <h3 class="flex_1 oh1 lh30 c3">采购人：{{ $value->name }} <span class="fz12"></span></h3>
                        {{--<span class="fz14 ca lh30">已解决</span>--}}
                    </div>
                    <div class="fz14 c9 lh30">收货地址：({{ $value->province }} {{ $value->city }} {{ $value->area }} {{ $value->address }})</div>
                    <div class="fz14 c6">描述：{{ $value->content }}
                    </div>
                </a>
            @endforeach
    @else
    <!-- 暂无数据 -->
    <div class="no_list">
        <img src="{{ asset('static/index/images/no_03.png') }}" alt="">
    </div>
    @endif
    </div>

    <div id="status" style="font-size:14px;display: none;line-height: 100px;text-align: center;color: #999;">
        暂无更多
    </div>

    <script>
        function keyup(event) { //回车时间
            var searchVal = $("#searchInput").val();
            if (event.keyCode == "13" && searchVal) {
                window.location.href = "{{ route('index.my_msg.index')}}?search="+searchVal;
            }
        }
        $(document.body).infinite();
        var loading = false;  //状态标记'
        var page_url = "{{ $msg->toArray()['next_page_url'] }}"
        $(document.body).infinite().on("infinite", function() {
            if(loading){
                $('#status').css('display','block');
                return;
            }
            loading = true;
            $.ajax({
                url:page_url,
                type:'post',
                dataType:'json',
                data:{
                    _token : "{{ csrf_token() }}",
                    search : $('input[name=search]').val(),
                },
                success:function(data){
                    console.log(data)
                    if (!data.data.next_page_url){
                        $('#list_box').append(data.html);
                        loading = true;
                    }else{
                        page_url = data.data.next_page_url;
                        $('#list_box').append(data.html);
                        loading = false;
                    }
                }
            })
        });
    </script>
@endsection