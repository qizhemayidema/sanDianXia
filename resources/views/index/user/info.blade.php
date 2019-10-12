@include('index.common.source')
        <!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        .weui-cells {
            margin-top: 10px;
        }
    </style>
</head>
<body class="bgf4">

<div id="app">
    <div class="bgf mb10">
        <div class="back_warppw flex jb_bg">
            <div class="back fz14 c3">
            </div>
            <div class="flex_1 tac fz16 c3 lh40">
                我的个人资料
            </div>
            <div onclick="location.href='{{ route('index.user.edit_info') }}'" class="back_right fz14 c3 fb">
                编辑
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">真实姓名：</label></div>
            <div class="weui-cell__bd"><input type="text" value="{{ $user_info->real_name }}" readonly="readonly"
                                              class="weui-input tar fz14 c9"></div>
        </div>
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">手机号：</label></div>
            <div class="weui-cell__bd"><input type="text" value="{{ $user_info->phone }}" readonly="readonly"
                                              class="weui-input tar fz14 c9"></div>
        </div>
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">销售品牌：</label></div>
            <div class="weui-cell__bd"><input type="text" value="{{ $user_info->profession }}" readonly="readonly"
                                              class="weui-input tar fz14 c9">
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form">
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">接收新商机通知</label></div>
            <div class="weui-cell__bd">
                <div class="weui-cell__ft"><input type="checkbox" @if($user_info->is_apply) checked
                                                  @endif onclick="isCheck(this,'isPush')" class="weui-switch">
                </div>
            </div>
        </div>
    </div>
    <div id="area_box" @if(!$user_info->is_apply) style="display: none;" @endif>
    <div class="weui-cells__title">接受以下地区商机</div>
    <div class="weui-cells weui-cells_checkbox mb20">
        @foreach($sub_area as $key => $value)
        <label for="s{{$key}}" class="weui-cell weui-check__label">
            <div class="weui-cell__hd">
                <input id="s{{$key}}"  type="checkbox" onclick="changeSubArea(this,'{{ $value['name'] }}')"  @if(in_array($value['name'],$user_info->sub_area)) checked @endif name="checkbox1" class="weui-check">
                <i class="weui-icon-checked"></i>
            </div>
            <div class="weui-cell__bd">
                <p class="fz14 c6">{{ $value['name'] }}</p>
            </div>
        </label>
        @endforeach
    </div>
    </div>

</div>
</body>
<script>

    function isCheck(el, name) { //接受商机切换
        if (!$(el).prop('checked')){
            $('#area_box').css('display','none');
        }else{
            $('#area_box').css('display','block');

        }
        el.checked
        changeSubStatus()
    }

    var changeSubArea = function(_this,area){
        $.ajax({
            url:"{{ route('index.user.change_sub_area') }}",
            type:'post',
            data:{
                _token:"{{ csrf_token() }}",
                area : area,
            },
            dataType:'json',
            success:function(data){
                console.log(data)
                var msg = '取消成功';
                if (data.type){
                    msg = '订阅成功';
                }
                layer.msg(msg)
            }
        })
    }
    var changeSubStatus = function(){
        $.ajax({
            url:"{{ route('index.user.change_sub_status') }}",
            type:'post',
            data:{
                _token:"{{ csrf_token() }}",
            },
            dataType:'json',
            success:function(data){
            }
        })
    }

</script>
</html>
