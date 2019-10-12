@extends('index.common.base')

@section('body')
    <div class="weui-search-bar" id="searchBar">
        <div class="weui-search-bar__form">
            <div class="weui-search-bar__box">
                <i class="weui-icon-search"></i>
                <input type="search" value="{{ $search }}" class="weui-search-bar__input" id="searchInput" placeholder="搜索" required="" onkeyup="keyup(event)">
                <a href="javascript:" class="weui-icon-clear" id="searchClear"></a>
            </div>
            <label class="weui-search-bar__label" id="searchText" style="transform-origin: 0px 0px 0px; opacity: 1; transform: scale(1, 1);">
                <i class="weui-icon-search"></i>
                <span>{{ $search ? $search : '搜索'}}</span>
            </label>
        </div>
        <a href="javascript:" class="weui-search-bar__cancel-btn" id="searchCancel">取消</a>
    </div>
    <!--  -->
    <!-- 首页列表 -->
    <div class="shop_list_box" id="list_box">
        @foreach($store as $key => $value)
        <a href="javascript:;" class="shop_list flex mb10">
            <div class="shop_logo">
                <img src="{{ '/' . $value->logo }}" alt="">
            </div>
            <div class="flex_1">
                <h3 class="oh1 fz16 c3 lh0">{{ $value->store_name }}</h3>
                <p class="fz12 c9">{{ date("Y-m-d",$value->create_time) }}</p>
            </div>
        </a>
        @endforeach
    </div>

    <div id="status" style="font-size:14px;display: none;line-height: 100px;text-align: center;color: #999;">
        暂无更多
    </div>
    <script>
        function keyup(event) { //回车时间
            var searchVal = $("#searchInput").val();
            if (event.keyCode == "13" && searchVal) {
                window.location.href = "{{ route('index.store.index') }}?search="+searchVal
            }
        }
        $(document.body).infinite();
        var loading = false;  //状态标记'
        var page_url = "{{ $store->toArray()['next_page_url'] }}"
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