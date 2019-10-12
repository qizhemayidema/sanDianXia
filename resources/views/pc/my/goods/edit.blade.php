@extends('pc.myBase.base')

@section('title') 编辑产品 @endsection

@section('source')
    <script src="{{ asset('static/admin/js/plugins/webuploader/webuploader.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('static/admin/css/plugins/webuploader/webuploader.css') }}">
    <style>
        #fileList{
            /*float: left;*/
            display: inline;
        }
        .uploader-list{
            padding-left: 110px;
        }
        .upload-state-done{
            display: inline-block;
            margin-right: 15px;
        }
        .clearfix:after{
            content:'';
            display: block;
            clear: both;
        }
    </style>
@endsection


@section('content')
    <form action="">
        {{ csrf_field() }}
        <input type="hidden" name="roll_pic" value="{{ $data->roll_pic }}">
        <input type="hidden" name="id" value="{{ $data->id }}">
        <!-- 我的发布 -->
        <div class="mybox_R_one hook" style="display: block;">
            <div class="my_b_r_type my_b_r_type1">
                <span class="">产品发布</span>
            </div>
            <div style="margin-top: 20px;">
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">产品标题：</div>
                    <div class="add_kuang fl">
                        <input type="text" name="title" value="{{ $data->title }}" class="fz16 c3 lh40">
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">官方分类：</div>
                    <div class="add_kuang fl">
                        <select name="cate_id" onchange="getAttr(this)">
                            @foreach($cate as $key => $value)
                                <option value="{{ $value['id'] }}" @if($data->cate_id == $value['id']) selected @endif>{{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">官方所属：</div>
                    <div class="add_kuang fl">
                        <select name="attr_id" id="">
                            @foreach($attr as $key => $value)
                                <option value="{{ $value['id'] }}" @if($data->attr_id == $value['id']) selected @endif>{{ $value['attr_name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">本店分类：</div>
                    <div class="add_kuang fl">
                        <select name="store_cate_id" id="">
                            @foreach($local_cate as $key => $value)
                                <option value="{{ $value->id }}"  @if($data->store_cate_id == $value['id']) selected @endif>{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">封面图：</div>
                    <div class="add_kuang fl" style="width: 162px;height: 82px;background-image: url({{ asset('static/pc/images/add.png') }});">
                        <p class="bg_img" style="background-image: url('{{ '/' . $data->pic }}')"></p>
                        <input type="file" class="file" name="pic" onchange="inputchange(this);">
                    </div>
                </div>
                <div class="add_list oh mb20" id="roll_pic_box">
                    <div class="add_list_name tar fz16 c9 lh40 fl">产品图片：</div>
                    <div id="uploader-demo">
                        <!--用来存放item-->
                        <div id="filePicker">选择图片</div>
                        <div id="fileList" class="uploader-list clearfix">
                            <div class="file-item thumbnail upload-state-done">
                                @foreach(explode(',',$data->roll_pic) as $key => $value)
                                    <img onclick="removePic(this,'{{ $value }}')" src="{{ '/' . $value }}" style="width: 100px;" alt="" >
                                @endforeach
                                (点击删除旧图片)

                            </div>
                        </div>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">规格介绍：</div>
                    <div class="add_kuang fl oh" style="width: 746px;height: 110px;border-radius: 5px;">
                        <textarea name="sku_desc" id="" rows="5">{{ $data->sku_desc }}</textarea>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">产品描述：</div>
                    <div class="add_kuang fl oh" style="width: 746px;height: 110px;border-radius: 5px;">
                        <textarea name="desc" id="" rows="5">{{ $data->desc }}</textarea>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">&nbsp;</div>
                    <div class="addBtn tal">
                        <button type="button" onclick="save()">编辑</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('js')
    <script>
        var removePic = function(_this,pic)
        {
            var result = [];
            var arr = $('input[name=roll_pic]').val().split(',')
            $(arr).each(function(k,v){
                if (v != pic){
                    result.push(v)
                }
            })
            var str = result.join(',')
            $('input[name=roll_pic]').val(str)
            $(_this).remove()
        }

        $(".open_box p").click(function(event) {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });
        var save = function(){
            var formData = new FormData($('form')[0]);
            $.ajax({
                url:"{{ route('pc.my.goods.update') }}",
                type:'post',
                dataType:'json',
                data:formData,
                contentType:false,
                processData:false,
                success:function(data){
                    if (data.code == 0){
                        layer.msg(data.msg)
                    } else{
                        layer.msg('修改成功')
                        setTimeout(function () {
                            window.location.reload()
                        },1500)
                    }
                }
            })
        }

        function inputchange(_this) {

            // if (_this.files[0].size / 1024 / 1024 > 3) {
            //     $.alert('视频大小超过3MB');
            //     return;
            // };
            var _this = _this;
            var file = _this.files[0];
            var reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(e) {
                $(_this).prev('p').css({ 'background-image': 'url(' + e.currentTarget.result + ')' })
            }
        }

        var getAttr = function(_this){
            var cate_id = $(_this).val();
            $.ajax({
                url : "{{ route('pc.my.goods.getAttr') }}",
                type: "post",
                dataType : "json",
                data : {
                    cate_id : cate_id,
                    _token : "{{ csrf_token() }}"
                },
                success : function(data){
                    let str = ``
                    $(data.data).each(function(k,v){
                        str += `<option value="${v.id}">${v.attr_name}</option>`
                    })
                    $('select[name=attr_id]').html(str)
                }
            })
        }


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
        // 当有文件添加进来的时候
        uploader.on( 'fileQueued', function( file ) {
            var $li = $(
                '<div id="' + file.id + '" class="file-item thumbnail">' +
                '<img>' +
                '<div class="info">' + file.name + '</div>' +
                '</div>'
                ),
                $img = $li.find('img');


            // $list为容器jQuery实例
            $list.append( $li );

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


        // 文件上传过程中创建进度条实时显示。
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
        uploader.on( 'uploadSuccess', function( file ,data) {
            roll_pic = $('input[name=roll_pic]').val()
            res = ''
            if (!roll_pic){
                res += data.path
            } else{
                res += roll_pic + ',' + data.path
            }
            console.log(res)
            $('input[name=roll_pic]').val(res)
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
    </script>
@endsection
