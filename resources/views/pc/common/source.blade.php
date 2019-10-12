<script src="{{ asset('static/pc/js/jquery-1.7.2.min.js') }}"></script>
<script src="{{ asset('static/pc/js/slick.js') }}"></script>
<script src="{{ asset('static/pc/layer/layer.js') }}"></script>
{{--<script src="js/mark.js"></script>--}}
<link rel="stylesheet" href="{{ asset('static/pc/css/weui.min.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/css/jquery-weui.min.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/fonts/style.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/css/jq22.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/css/slick.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/css/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('static/pc/css/page.css') }}">
<script>

    var loginHTML = '<div class="login_warpper">' +
        '<div class="login_box height_auto">' +
        '<div class="login_close"><img src="{{ asset('static/pc/images/close.png') }}" alt="" onclick="close_box()"></div>' +
        '<div class="tac">' +
        '<img src="images/index_10.jpg" alt="" class="mb20">' +
        '</div>' +
        '<div class="hook_tab">' +
        '<div class="l_title tac">登录</div>' +
        '<div class="login_list">' +
        '<input type="text" class="fz14 c3" data-reg="/^1[3-9]\\d{9}$/" id="tel" data-validation="true" data-error="请输入手机号"  placeholder="请输入手机号">' +
        '</div>' +
        '<div class="login_list">' +
        '<input type="password" class="fz14 c3" placeholder="请输入密码" data-reg="/\\S/" data-validation="true" data-error="请输入密码" placeholder="请输入密码">' +
        '</div>' +
        '<div class="submit_btn">' +
        '<button type="button" class="" onclick="submit(\'asdasdasdd\');">登录</button>' +
        '</div>' +
        '<div class="w314 fz14 lh30 c9">' +
        '</div>'+
        '</div>' +
        '</div>';

    function close_box() { //关闭层
        $(".login_warpper").remove();
    }

    function showMarks(name) { //打开登录层
        var dom = $(".login_warpper");
        if (dom.length > 0) { //元素已存在
            $(".hook_tab").html(name);
        } else { //元素不存在
            appendHtml(name);
        }
    }

    function submit(url) {
        var isSubmit = true;
        // $('.login_warpper input').each(function(key, el) {
        //     if ($(el).attr('data-validation') == 'true') {
        //         var reg = eval($(el).attr('data-reg'));
        //         var msg = $(el).attr('data-error');
        //         var value = $(el).val();
        //         if (!reg.test(value)) {
        //             layer.msg(msg)
        //             isSubmit = false;
        //             return false;
        //         }
        //     }
        // });
        if (isSubmit) {
            var username = $('#tel').val();
            var password = $('input[type=password]').val();

            $.ajax({
                url:"{{ route('pc.login.login') }}",
                type:"post",
                dataType:'json',
                data:{
                    '_token' : '{{ csrf_token() }}',
                    'username' : username,
                    'password' : password
                },
                success:function(data){
                    if (data.code == 0){
                        layer.msg(data.msg)
                    } else{
                        layer.msg('登陆成功')
                        setTimeout(function(){
                            window.location.reload()
                        })
                    }
                    console.log(data)
                }
            })
        }

    };

    function appendHtml(name) {

        $("body").append(name);
    }

</script>