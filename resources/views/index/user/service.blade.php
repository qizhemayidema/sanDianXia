<link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
<style>
    .table tr{
        text-align: center;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        vertical-align: middle;
    }
    .table button{
        border-radius: 5px;
        color: #fff;
        background: #50cc99;
        width: 80px;
        height: 40px;
    }
    .table{
        margin-bottom: 0;
    }
</style>
@extends('index.common.basic')

@section('body')
    <div class="bgf p10_3 mb10">
        <div class="service_title juc itc flex">
            <p></p>
            <h3 class="fz14 fw9 red lh30">金牌会员服务</h3>
            <p></p>
        </div>
        <div class="mb10">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="fz14 c3 tac">等级</th>
                    <th class="fz14 c3 tac">服务内容</th>
                    <th class="fz14 c3 tac"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($vip as $key => $value)
                <tr>
                    <td width="100"><span class="red"><span class="fz20">{{ $value->name }} </span>{{ $value->money }}元/年</span> </td>
                    <td class="fz14 c6">购买商机享受<span class="red">{{ $value->discount }}折</span>优惠优先<span class="red">
                            @if($value->precedence >= 60 && $value->precedence % 60 == 0)
                                {{ $value->precedence / 60 }}分钟
                                @elseif($value->precedence >= 60)
                                {{ floor($value->precedence / 60) }}分{{ $value->precedence % 60 }}秒
                                @else
                                {{ $value->precedence }}秒
                            @endif
                        </span>收到提醒</td>
                    <td width="90"><button type="button" class="fz14 c6" onclick="kai('{{ $value->id }}')">
                            @if($userVip)
                                @if($userVip['id'] == $value->id)
                                    续费
                                @elseif($userVip['money'] < $value->money)
                                    升级
                                @endif
                                @else
                                自助开通
                            @endif
                        </button>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <div class="bgf p10_3 mb10" id="shop">
        <div class="service_title juc itc flex">
            <p></p>
            <h3 class="fz14 fw9 red lh30">企业店铺服务</h3>
            <p></p>
        </div>
        <div class="fz14 c3 tac mb10"></div>
        <div class="mb10">
            <table class="table table-bordered">
                <tbody>
                @foreach($store as $key => $value)
                <tr>
                    <td class="fz14 c6"><span class="red">{{ $value->name }}</span>   <span class="red">{{ $value->money }}元/年</span></td>
                    <td width="90"><button type="button" class="fz14 c6" onclick="kai_service('{{ $value->id }}')">
                            @if(request()->user_info->store_service_id)
                                续费
                            @else
                                自助开通
                            @endif
                        </button></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
    <script>
        var jsApiParameters = '';
        var kai = function(vip_id){
            $.ajax({
                url:"{{ route('index.pay.vip') }}",
                type:'post',
                data:{
                    _token:'{{ csrf_token() }}',
                    vip_id:vip_id,
                },
                dataType:'json',
                success:function(data){
                    if(data.code==1){
                        jsApiParameters = JSON.parse(data.jsApiParameters);
                        callPay();
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(){
                    layer.msg('充值失败,请稍后尝试')
                }
            })
        }

        var kai_service = function(service_id){
            $.ajax({
                url:"{{ route('index.pay.service') }}",
                type:'post',
                data:{
                    _token:'{{ csrf_token() }}',
                    service_id:service_id,
                },
                dataType:'json',
                success:function(data){
                    if(data.code==1){
                        jsApiParameters = JSON.parse(data.jsApiParameters);
                        callPay();
                    }else{
                        alert(data.msg);
                    }
                },
                error:function(){
                    layer.msg('充值失败,请稍后尝试')
                }
            })
        }

        function callPay() {
            if (typeof WeixinJSBridge == "undefined"){
                if( document.addEventListener ){
                    document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                }else if (document.attachEvent){
                    document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                    document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                }
            }else{
                jsApiCall();
            }
        }

        function jsApiCall()
        {
            WeixinJSBridge.invoke(
                'getBrandWCPayRequest',jsApiParameters,
                function(res){
                    //WeixinJSBridge.log(res.err_msg);
                    if (res.err_msg == "get_brand_wcpay_request:ok") {
                        alert('支付成功')
                        //可以进行查看订单，等操作
                    } else {
                        alert('支付失败！');
                        console.log(res)
                    }
                    //alert(res.err_code+res.err_desc+res.err_msg);
                }
            );
        }
    </script>
@endsection