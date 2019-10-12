<style>
    img{
        width: 60px;
        height: 60px;
        border-radius: 50%;
    }
</style>
@extends('index.common.basic')

@section('body')
    <div class="weui-panel weui-panel_access">
        <div class="weui-panel__bd" id="list_box">
            @foreach($history as $key => $value)
            <a href="javascript:void(0);" class="weui-media-box weui-media-box_appmsg">
                <div class="weui-media-box__hd">
                    <img src="{{ asset('static/index/images/ka_03.png') }}" alt="" width="60" height="60">
                </div>
                <div class="weui-media-box__bd">
                    <h4 class="weui-media-box__title">
                        @if($value->type == 1)
                            开通会员
                        @elseif($value->type == 2)
                            开通店铺
                        @elseif($value->type == 3)
                            购买商机
                        @elseif($value->type == 4)
                            充值
                            @endif
                    </h4>
                    <p class="weui-media-box__desc">{{ date("Y-m-d H:i:s",$value->create_time) }}</p>
                </div>
                <div class="fz20 c3 @if(in_array($value->type,[1,2,3])) red @endif">
                    @if(in_array($value->type,[1,2,3])) -  @endif
                    {{ $value->money }}
                </div>
            </a>
            @endforeach
        </div>

        <div id="status" style="font-size:14px;display: none;line-height: 100px;text-align: center;color: #999;">
            暂无更多
        </div>
    </div>
    <script>
        $(document.body).infinite();
        var loading = false;  //状态标记'
        var page_url = "{{ $history->toArray()['next_page_url'] }}"
        $(document.body).infinite().on("infinite", function() {
            if(loading){
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
                        $('#status').css('display','block');

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