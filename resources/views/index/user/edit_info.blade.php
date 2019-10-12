<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('index.common.source')
</head>
<body class="bgf4">
<div id="app">
    <div class="bgf mb10">
        <div class="back_warppw flex jb_bg">
            <div class="back fz14 c3" onclick="javascript:history.back(-1);">
                <span class="icon icon-uniE918"></span>
            </div>
            <div class="flex_1 tac fz16 c3 lh40">
                完善个人信息
            </div>
        </div>
    </div>
    <div class="weui-cells weui-cells_form mb20">
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">真实姓名：</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input fz14 c9" type="text" name="real_name" value="{{ $user->real_name }}" placeholder="输入真实姓名" data-msg="请输入姓名" data-reg="/\S/" data-validation="true">
            </div>
        </div>
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">手机号：</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input fz14 c9" type="text" name="phone" value="{{ $user->phone }}" placeholder="输入手机号" data-msg="请输正确入手机号" data-reg="/^1[3-9]\d{9}$/" data-validation="true" id="tel">
            </div>
            <div class="getCode">
                <button type="button" onclick="getCode(this);" id="codeval_btn">验证码</button>
            </div>
        </div>
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">验证码：</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input fz14 c9" type="text" name="phone_code" placeholder="输入验证码" data-msg="输入验证码" data-reg="/\S/" data-validation="true">
            </div>
        </div>
        <div class="weui-cell">
            <div class=" weui-cell__hd fz14 c3"><label class="weui-label">销售品牌：</label></div>
            <div class="weui-cell__bd">
                <input class="weui-input fz14 c9" type="text" name="profession" value="{{ $user->profession }}" placeholder="品牌名称/厂家名称" data-msg="请输入品牌名称/厂家名称" data-reg="/\S/" data-validation="true">
            </div>
        </div>
    </div>
    <div class="submit_box">
        <button type="button" onclick="submit();">提交保存</button>
    </div>
</div>

<script>
    var reg = /^1[3-9]\d{9}$/;
    var time = 60;

    function getCode(el) {
        if (!reg.test($("#tel").val())) {
            $.toast("手机号不正确", "cancel");
            return;
        };
        $(el).attr('disabled', true);
        //成功回调执行
        $.ajax({
            url:"{{ route('index.user.get_phone_code') }}",
            type:'post',
            dataType:'json',
            data:{
                _token : "{{ csrf_token() }}",
                phone : $('input[name=phone]').val()
            },
            success:function(data){
                if (data.code == 1){
                    var countDown = setInterval(function() {
                        if (time == 1) {
                            time = 60;
                            $(el).html('验证码');
                            clearInterval(countDown);
                            $(el).removeAttr('disabled');
                        } else {
                            time--;
                            $(el).html(time + 's');
                        }
                    }, 1000);
                }else{
                    layer.msg(data.msg)
                }
            }
        })

    }

    function submit() { //提交
        var isSubmit = true;
        // $('input,.imginp').each(function(key, el) {
        //     if ($(el).attr('data-validation') == 'true') {
        //         var reg = eval($(el).attr('data-reg'));
        //         var msg = $(el).attr('data-msg');
        //         var value = $(el).attr('value');
        //         if (!reg.test(value)) {
        //             $.toptip(msg, 'error');
        //             isSubmit = false;
        //             $(window).scrollTop($(el).offset().top - 40);
        //             return false;
        //         }
        //     }
        // });
        if (isSubmit) {
            //成功回调执行
            $.ajax({
                url:"{{ route('index.user.update_info') }}",
                type:'post',
                dataType:'json',
                data:{
                    _token : "{{ csrf_token() }}",
                    phone : $('input[name=phone]').val(),
                    phone_code:$('input[name=phone_code]').val(),
                    profession:$('input[name=profession]').val(),
                    real_name:$('input[name=real_name]').val(),
                },
                success:function(data){
                    if (data.code == 1){
                        layer.msg('修改成功');
                        setTimeout(function(){
                            window.location.href = "{{ route('index.user.info') }}"
                        },600)
                    }else{
                        layer.msg(data.msg)
                    }
                }
            })
        }
    }
</script>

</body>
</html>