@extends('index.common.base')

@section('body')
    <div class="center_top_box bgf mb10">
        <div class="shop_list_box">
            <a href="javascript:void(0);" class="shop_list flex mb10">
                <div class="shop_logo">
                    <img src="{{ $user_info->avatar_url }}" alt="">
                </div>
                <div class="flex_1">
                    <h3 class="oh1 fz16 c3 lh0">{{ $user_info->nickname }}</h3>
                    <p class="fz12 c9">账户余额：{{ $user_info->money }}元</p>
                </div>
            </a>
        </div>
        <a href="{{ route('index.user.info') }}" class="set"><span class="icon-10 fz20 c6"></span></a>
    </div>
    <!-- 充值 -->
    <div class="bgf mb10">
        <div class="p10_3">
            <div class="fz12 c9 mb10">提示：首次充值每满100即送{{ 100 * $first_pay }}。200送{{ 200 * $first_pay }}，300送{{ 300 * $first_pay }}，以此类推。</div>
            <div class="flex topUp_box itc mb10">
                <div class="tac">
                    <p class="ca fz14">首冲送{{ $first_pay * 100 }}%</p>
                    <h3 class="ca fz18">1000</h3>
                    <span class="fz12 c6">实得{{ (1+$first_pay) * 1000}}</span>
                </div>
                <div class="tac">
                    <p class="ca fz14">首冲送{{ $first_pay * 100 }}%</p>
                    <h3 class="ca fz18">2000</h3>
                    <span class="fz12 c6">实得{{ (1+$first_pay) * 2000}}</span>
                </div>
                <div class="tac">
                    <p class="ca fz14">首冲送{{ $first_pay * 100 }}%</p>
                    <h3 class="ca fz18">3000</h3>
                    <span class="fz12 c6">实得{{ (1+$first_pay) * 3000}}</span>
                </div>
            </div>
            <div class="flex topUp">
                <div class="flex_1">
                    <div class="flex">
                        <p class="fz14 c3 lh30">充值金额：</p>
                        <input type="number" id="price" placeholder="请输入金额" class=" fz14 c3 lh30">
                    </div>
                </div>
                <p class="red fz14 lh30 giving"></p>
                <button type="button" class="topUpBtn" onclick="credit()">立即充值</button>
            </div>
        </div>
    </div>
    <!-- 专属权益 -->
    <div class="bgf">
        <div class="p10_3">
            <h3 class="fz20 c3 mb10">专属权益</h3>
            <div class="flex privilege_box">
                <a href="{{ route('index.message.sub') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_03.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">定制商机</h3>
                </a>
                <a href="{{ route('index.user.service') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_05.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">服务</h3>
                </a>
                <a href="{{ route('index.user.history') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_07.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">账户明细</h3>
                </a>
                <a href="{{ route('index.my_msg.index') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_09.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">我的商机</h3>
                </a>
                <a href="{{ route('index.user.my_service') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_15.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">已买服务</h3>
                </a>
                <a href="{{ route('index.store.index') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_16.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">企业店铺</h3>
                </a>
                <a href="{{ route('index.user.feedback') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_17.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">意见反馈</h3>
                </a>
                <a href="{{ route('index.user.about') }}" class="privilege_list tac">
                    <div>
                        <img src="{{ asset('static/index/images/center_18.png') }}" alt="">
                    </div>
                    <h3 class="fz14 c3 lh20">关于我们</h3>
                </a>
            </div>
        </div>
    </div>

    <script>
        var jsApiParameters = '';
        var credit = function(){
            $.ajax({
                url:"{{ route('index.pay.credit') }}",
                type:'post',
                data:{
                    _token:'{{ csrf_token() }}',
                    pay_money:$('#price').val(),
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
        $("#price").bind('input', function() { //赠送金额计算
            var val = $("#price").val();
            var dom = $(".giving");
            if (val === '') {
                dom.html('');
            } else {
                @if($user_info->pay_money == 0)
                dom.html((val * (1 + {{ $first_pay }})).toFixed(2));
                @else
                dom.html(val);
                @endif
            }
        })
    </script>
@endsection