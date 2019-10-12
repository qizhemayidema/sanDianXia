@include('admin.common.source')
<link rel="stylesheet" href="{{ asset('static/admin/css/plugins/simditor/simditor.css') }}">
<script src="https://unpkg.com/wangeditor/release/wangEditor.min.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('static/admin/css/plugins/webuploader/webuploader.css') }}">
<script type="text/javascript" src="{{ asset('static/admin/js/plugins/webuploader/webuploader.js') }}"></script>
<div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <input type="hidden" name="qrCode" value="{{ $config->qrCode }}">
            <div class="form-group">
                <label class="col-sm-2 control-label">关于我们</label>

                <div class="col-sm-8">
                    <div id="about">

                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">联系电话</label>

                <div class="col-sm-8">
                    <input type="text" name="phone" value="{{ $config->phone }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">上班时间</label>

                <div class="col-sm-8">
                    <input type="text" placeholder="例如 9:00" value="{{ $config->start_time }}" name="start_time" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">下班时间</label>

                <div class="col-sm-8">
                    <input type="text" placeholder="例如 17:00" value="{{ $config->end_time }}" name="end_time" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">客服二维码</label>

                <div class="col-sm-8">
                    <!--dom结构部分-->
                    <div id="uploader-demo">
                        <div id="filePicker" style="margin-bottom: 10px;">选择图片</div>

                        <!--用来存放item-->
                        <div id="fileList" class="uploader-list">
                            <div class="file-item thumbnail upload-state-done">
                                <img src="{{ '/' . $config->qrCode}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">备案号</label>

                <div class="col-sm-8">
                    <input type="text" placeholder="例如 豫ICP备17027413号-1 " value="{{ $config->icp }}" name="icp" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">电信经营业务许可证</label>

                <div class="col-sm-8">
                    <input type="text" value="{{ $config->dianXin }}" placeholder="例如 豫B2-20190551 " {{ $config->dianXin }} name="dianXin" class="form-control">

                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-5">
                    <button type="button" class="btn btn-w-m btn-success" onclick="save()">修改</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    var $list = $("#fileList");
    // 初始化Web Uploader
    var uploader = WebUploader.create({

        // 选完文件后，是否自动上传。
        auto: true,

        // swf文件路径
        swf: "{{ asset('static/admin/js/plugins/webuploader/Uploader.swf') }}",


        // 文件接收服务端。
        server: " {{ route('common.upload.uploadCommonImage') }}",

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: '#filePicker',

        // 只允许选择图片文件。
        accept: {
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        }
    });
    uploader.on( 'fileQueued', function( file ) {
        var $li = $(
            '<div id="' + file.id + '" class="file-item thumbnail">' +
            '<img>' +
            '<div class="info">' + file.name + '</div>' +
            '</div>'
            ),
            $img = $li.find('img');


        // $list为容器jQuery实例
        $list.html( $li );

        // 创建缩略图
        // 如果为非图片文件，可以不用调用此方法。
        // thumbnailWidth x thumbnailHeight 为 100 x 100
        uploader.makeThumb( file, function( error, src ) {
            if ( error ) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }

            $img.attr( 'src', src );
        }, 100, 100 );
    });
    uploader.on( 'uploadProgress', function( file, percentage ) {
        var $li = $( '#'+file.id ),
            $percent = $li.find('.progress span');

        // 避免重复创建
        if ( !$percent.length ) {
            $percent = $('<p class="progress"><span></span></p>')
                .appendTo( $li )
                .find('span');
        }

        $percent.css( 'width', percentage * 100 + '%' );
    });

    // 文件上传成功，给item添加成功class, 用样式标记上传成功。
    uploader.on( 'uploadSuccess', function( file ,response) {
        $('input[name=qrCode]').val(response.path)
        $( '#'+file.id ).addClass('upload-state-done');
    });

    // 文件上传失败，显示上传出错。
    uploader.on( 'uploadError', function( file ) {
        var $li = $( '#'+file.id ),
            $error = $li.find('div.error');

        // 避免重复创建
        if ( !$error.length ) {
            $error = $('<div class="error"></div>').appendTo( $li );
        }

        $error.text('上传失败');
    });

    // 完成上传完了，成功或者失败，先删除进度条。
    uploader.on( 'uploadComplete', function( file ) {
        $( '#'+file.id ).find('.progress').remove();
    });

    var editor;
    $(document).ready(function () {
        var E = window.wangEditor
        editor = new E('#about')
        editor.create()
        editor.txt.html('{!!  $config->aboutOur  !!}')
    });

    var save = function(){
        var formData = new FormData($('form')[0]);
        formData.append('aboutOur',editor.txt.html())
        $.ajax({
            url:"{{ route('admin.config.save') }}",
            type:'post',
            dataType:'json',
            data:formData,
            processData:false,
            contentType:false,
            success:function(data){
                if (data.code == 0){
                    layer.msg(data.msg,{icon:5})
                } else{
                    layer.msg('修改成功',{icon:1});
                    setTimeout(function(){
                        window.location.href = "{{ route('admin.config.index') }}";
                    },600)
                }
            }
        })
    }
</script>
