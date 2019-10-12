@extends('index.common.base')
@section('title') 详情 @endsection

@section('body')
    <div class="bgf bb1 mb10">
        <a href="javascript:void(0);" class="index_list mb10 bgf">
            <div class="flex index_list_title">
                <h3 class="flex_1 oh1 lh30 c3" style="color: #333;"</span></h3>
            </div>>采购人：{{ $data->name }} <span class="fz12">({{ $data->province }} {{ $data->city }} {{ $data->area }} {{ $data->address }})
            <div class="fz12 c9 lh20">发布时间：{{ date("Y-m-d H:i:s",$data->create_time) }}</div>
            <div class="flex index_list_title">
                <h3 class="flex_1 oh1 lh30">联系方式：{{ $data->phone }}（接单后可见）</h3>
            </div>
            <div class="fz14 c9 bb1 pb10">描述：{{ $data->content }}
            </div>
            <div class="flex">
                <div class="index_list_progress flex_1 bgf4">
                        <div style="width: {{ $data->accept_sum * 25 }}%;"></div>
                </div>
                <div class="fz14 ca" style="line-height: 26px;">{{ $data->accept_sum }}/4</div>
            </div>
            <div class="fz14 c9 mb10">剩余{{ 4 - $data->accept_sum }}次接单机会</div>
            <div class="info_btn_box flex">
                <button type="button" @if($data->accept_sum == 4) disabled @else onclick="buy('{{ $data->id }}','all')" @endif class="flex_1 lh40 info_btn_all">买断剩余名额</button>
                <button type="button" @if($data->accept_sum == 4) disabled @else onclick="buy('{{ $data->id }}','one')" @endif class="flex_1 lh40 info_btn">立即接单</button>
            </div>
        </a>
    </div>
    <div class="bgf mb10 bb1">
        <div class="p10_3">
            <div class="flex mb10">
                <span class="icon-12 lh30 red mr10"></span>
                <p class="flex_1 fz12 lh30 red">免预约接收商机，优先接收提醒，享受折扣优惠</p>
            </div>
            <div class="flex service">
                <div class="">
                    <a href="{{ route('index.user.service') }}" class="flex">
                        <span class="icon-9  fz18 lh40 cf "></span>
                        <p class="lh40 cf fz14">金牌会员</p>
                    </a>
                </div>
                <div class="">
                    <a href="{{ route('index.user.service') }}" class="flex">
                        <span class="icon-uniE900  fz18 lh40 cf "></span>
                        <p class="lh40 cf fz14">企业店铺</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="bgf mb10">
        <div class="lh40 fz16 fw9 bb1"><div class="p0_3 ca">接单人员</div></div>
        @foreach($userhy as $key => $value)
        <div class="lh40 fz16  bb1">
            <div class="p0_3 flex fz14 c9">
                <div class="flex_1 tal">
                    @if($value->real_name)
                        {{ mb_substr($value->real_name,0,1) }}**
                        @else
                        匿名
                    @endif
                </div>
                <div class="flex_1 tac">{{ date("m-d H:i",$value->create_time) }}</div>
                <div class="flex_1 tar">{{ $value->num }}</div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="bgf">
        <div class="lh40 fz16 fw9 bb1"><div class="p0_3 ca">最新可接单询盘</div></div>
        @foreach($new as $key => $value)
        <a href="{{ route('index.message.info',['msg_id'=>$value->id]) }}" class="p10_3 flex bb1">
            <div class="flex_1">
                <h3 class="fz14 c9 lh30 oh1">{{ $value->title }}</h3>
                <p class="fz12 c9">{{ $value->province }} {{ $value->city }} {{ $value->area }}</p>
            </div>
            <div class=" fz14">
                <h3 class="c9 lh30">
                    <?php $temp = time() - $value->create_time; ?>
                    @if($temp < 60)
                    {{ $temp }}秒前发布
                    @elseif($temp > 60 && $temp < 3600)
                    {{ floor($temp / 60) }}分钟前发布
                    @elseif($temp > 3600 && $temp < 86400)
                   {{ floor($temp / 60 / 60) }}小时前发布
                    @elseif($temp < 31536000)
                    {{ floor($temp / 60 / 60 / 24) }}天前发布
                    @else
                    {{ floor($temp / 60 / 60 / 24 / 365) }}年前发布
                    @endif
                </h3>
                <p class="ca tar">{{ $value->accept_sum }}/4</p>
            </div>
        </a>
        @endforeach
        <script>
            var buy = function(msg_id,type){
                var msg = type == 'all' ? '您确定买断吗?' : '您确定接单吗?';
                layer.confirm(msg,function(){
                    $.ajax({
                        data:{
                            _token:"{{ csrf_token() }}",
                            msg_id:msg_id,
                            type:type,
                        },
                        url:"{{ route('index.message.buy') }}",
                        type:"post",
                        dataType:"json",
                        success:function(data){
                            if (data.code == 0){
                                layer.msg(data.msg)
                            } else{
                                layer.msg('购买成功');
                                setTimeout(function(){
                                    window.location.reload()
                                },600);
                            }
                        }
                    })
                })
            }
        </script>
@endsection