@extends('pc.myBase.base')

@section('title') 信息设置 @endsection

@section('content')
    <form action="">
        {{ csrf_field() }}
    <div class="mybox_R_one hook" style="display: block;">
        <div class="my_b_r_type my_b_r_type1">
            <span class="">信息设置</span>
        </div>
        <div style="margin-top: 20px;">
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">公司名称：</div>
                <div class="add_kuang fl">
                    <input type="text" name="store_name" value="{{ $data->store_name }}" class="fz16 c3 lh40">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">销售工程师：</div>
                <div class="add_kuang fl">
                    <input type="text" name="contact" value="{{ $data->contact }}" class="fz16 c3 lh40">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">联系电话：</div>
                <div class="add_kuang fl">
                    <input type="text" name="phone" value="{{ $data->phone }}" class="fz16 c3 lh40">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">经营范围：</div>
                <div class="add_kuang fl">
                    <input type="text" name="business_scope" value="{{ $data->business_scope }}" class="fz16 c3 lh40">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">Logo：</div>
                <div class="add_kuang fl" style="width: 162px;height: 82px;background-image: url({{ asset('static/pc/images/add.png') }});">
                    <p class="bg_img" style="background-image: url({{ '/' . $data->logo }});"></p>
                    <input type="file" name="logo" class="file" onchange="inputchange(this);">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">顶部图片：</div>
                <div class="add_kuang fl" style="width: 443px;height: 82px;background-image: url({{ asset('static/pc/images/add.png') }});">
                    <p class="bg_img" style="background-image: url({{ '/' . $data->banner }});"></p>
                    <input type="file" name="banner" class="file" onchange="inputchange(this);">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">联系地址：</div>
                <div class="add_kuang fl" style="width: 268px;">
                    <input type="text" name="area" value="{{ $data->area }}" class="fz16 c3 lh40">
                </div>
            </div>
            <div class="add_list oh mb20">
                <div class="add_list_name tar fz16 c9 lh40 fl">&nbsp;</div>
                <div class="addBtn tal">
                    <button type="button" onclick="save()">保存</button>
                </div>
            </div>
        </div>
    </div>
    </form>
@endsection

@section('js')
    <script>
        var save = function(){
            var formData = new FormData($('form')[0]);
            $.ajax({
                url:"{{ route('pc.my.info.save') }}",
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
    </script>
@endsection