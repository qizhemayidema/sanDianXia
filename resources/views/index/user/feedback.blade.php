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
<div class="p10_3 bgf">
    <textarea rows="8" id="content" class="feed_text fz14 c6" placeholder="请输入反馈内容，我们将不断改进"></textarea>
</div>
<div class="p10_3 fz14 c3">常见问题</div>
<div class="bb1 p10_3 oh1 fz14 c3 bgf">
    <a href="" class="c3 lh30">*您希望得到什么产品或项目的商机？</a>
</div>
<div class="bb1 p10_3 oh1 fz14 c3 bgf">
    <a href="" class="c3 lh30">*您在使用公众号的过程中遇到过什么问题？</a>
</div>
<div class="bb1 p10_3 oh1 fz14 c3 bgf">
    <a href="" class="c3 lh30">*您对我们的服务有什么意见或建议？</a>
</div>
<div class="submit_box mt10"><button type="button" onclick="submit_form()">反馈</button></div>

<script>
    var submit_form = function(){
        $.ajax({
            url:"{{ route('index.user.feedback_save') }}",
            type:'post',
            dataType:'json',
            data:{
                _token : "{{ csrf_token() }}",
                content : $('#content').val(),
            },
            success:function(data){
                if (data.code == 1){
                    layer.msg('反馈成功');
                    setTimeout(function(){
                        window.location.href = "{{ route('index.index') }}";
                    },600)
                }else{
                    layer.msg(data.msg);
                }
            }
        })
    }
    $(function(){

    })
</script>
</body>
</html>