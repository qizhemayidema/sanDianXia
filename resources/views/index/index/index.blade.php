@extends('index.common.base')
@section('title') 首页 @endsection
@section('body')
    <div class="h50 mb10"></div>
    <div class="index_search_box flex">
        <div class="i_name lh30 tac fz14 c3">机械超人</div>
        <div class="flex_1 bgf4">
            <div class="flex">
                <input type="text" name="search" value="{{ $search }}" class="flex_1" placeholder="请输入搜索内容"
                       onkeyup="keyup(event,this);">
                <button type="button"
                        onclick="window.location.href='{{ route('index.index') }}?search='+$('input[name=search]').val()">
                    <span class="icon-11 c9"></span></button>
            </div>
        </div>
    </div>
    <div id="list_box">
        @if(count($message))
            @foreach($message as $key => $msg)
                <a href="{{ route('index.message.info',['msg_id'=>$msg->id]) }}" class="index_list mb10 bgf">
                    <div class="flex index_list_title">
                        <h3 class="flex_1 oh1 lh30">{{ $msg->title }}</h3>
                        <span class="fz12 c9 lh30">{{ date("Y-m-d H:i:s",$msg->create_time) }}</span>
                    </div>
                    <div class="fz14 c3 lh30">
                        收货地址：{{ $msg->province }} {{ $msg->city }} {{ $msg->area }} {{ $msg->address }}</div>
                    <div class="fz14 c9 bb1 pb10">描述：{{ $msg->content }}
                    </div>
                    <div class="flex">
                        <div class="index_list_progress flex_1 bgf4">
                            <div style="width: {{ 25 * $msg->accept_sum }}%;"></div>
                        </div>
                        <div class="fz14 ca" style="line-height: 26px;">{{ $msg->accept_sum }}/4</div>
                    </div>
                    <div class="fz14 c9">{{ $msg->accept_sum }}人参与</div>
                </a>
            @endforeach
        @else
            <div class="no_list">
                <a href="{{ route('index.message.sub') }}"><img src="{{ asset('static/index/images/toset_03.png') }}"
                                                                alt=""></a>
            </div>
        @endif
    </div>
    <div id="status" style="font-size:14px;display: none;line-height: 100px;text-align: center;color: #999;">
        暂无更多
    </div>

    <script>
        function keyup(event, dom) { //回车时间
            if (event.keyCode == "13" && $(dom).val()) {
                window.location.href = "{{ route('index.index') }}?search="+$(dom).val();
                console.log($(dom).val())
            }
        }

        $(document.body).infinite();
        var loading = false;  //状态标记'
        var page_url = "{{ $message->toArray()['next_page_url'] }}"
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
                    if (data.code == 1){
                        if (!data.data.next_page_url){
                            $('#list_box').append(data.html);
                            loading = true;
                        }else{
                            page_url = data.data.next_page_url;
                            $('#list_box').append(data.html);
                            loading = false;
                        }
                    }
                }
            })
        });
    </script>
@endsection