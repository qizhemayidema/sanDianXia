<!DOCTYPE html>
<html>


<!-- Mirrored from www.zi-han.net/theme/hplus/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 20 Jan 2016 14:18:23 GMT -->
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>后台 - 登录</title>
    <link href="{{ asset('static/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">


</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name"></h1>

        </div>
        <h3>欢迎登陆</h3>

        <form class="m-t" role="form" action="http://www.zi-han.net/theme/hplus/index.html">
            {{ csrf_field() }}
            <div class="form-group">
                <input type="text" name="user_name" class="form-control" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" name="password" class="form-control" placeholder="密码" required="">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>

        </form>
    </div>
</div>
<script src="{{ asset('static/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ asset('static/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
<script>
    $(function(){
        $('form').submit(function(){
            var formData = new FormData($('form')[0]);

            $.ajax({
                url:"{{ route('admin.login.check')  }}",
                type:'post',
                dataType:'json',
                data:formData,
                processData:false,
                contentType:false,
                success:function(data){
                    console.log(data)
                    if (data.code == 1){
                        window.location.href = "{{ route('admin.index.index') }}";
                    } else{
                        layer.msg(data.msg,{icon: 5})
                    }
                    // if (data.code == )
                }
            })
            return false;
        })
    })
</script>
</body>


</html>
