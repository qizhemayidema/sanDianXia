@extends('pc.myBase.base')

@section('content')
    <form action="">
        <input type="hidden" name="id" value="{{ $data->id }}">
        {{ csrf_field() }}
        <div class="mybox_R_one hook" style="display: block;">
            <div class="my_b_r_type my_b_r_type1">
                <span class="">编辑</span>
            </div>
            <div style="margin-top: 20px;">

                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">发布类型：</div>
                    <div class="add_kuang fl">
                        <select name="type">
                            <option value="1" @if($data->type == 1) selected @endif>资讯</option>
                            <option value="2" @if($data->type == 2) selected @endif>常见问题</option>
                        </select>
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">标题：</div>
                    <div class="add_kuang fl">
                        <input type="text" value="{{ $data->title }}" name="title" class="fz16 c3 lh40">
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">封面图：</div>
                    <div class="add_kuang fl" style="width: 162px;height: 82px;background-image: url({{ asset('static/pc/images/add.png') }});">
                        <p class="bg_img" style="background-image: url('{{ '/' . $data->pic }}')"></p>
                        <input type="file" name="pic" class="file" onchange="inputchange(this);">
                    </div>
                </div>
                <div class="add_list oh mb20">
                    <div class="add_list_name tar fz16 c9 lh40 fl">详情：</div>
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
        var save = function(){
            var formData = new FormData($('form')[0]);
            $.ajax({
                url:"{{ route('pc.my.article.update') }}",
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
    </script>
@endsection