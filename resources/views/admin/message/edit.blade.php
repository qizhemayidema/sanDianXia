@include('admin.common.source')
<script src="{{ asset('static/admin/js/plugins/layer/laydate/laydate.js') }}"></script>
<script src="{{ asset('static/admin/js/plugins/layer/laydate/need/laydate.css') }}"></script>
<script src="{{ asset('static/admin/js/plugins/layer/laydate/skins/default/laydate.css') }}"></script>
<link rel="stylesheet" href="{{ asset('static/admin/js/city/css/pick.css') }}">
<script src="{{ asset('static/admin/js/city/js/pick.js') }}"></script>
<div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">称呼</label>
                <div class="col-sm-5">
                    <input name="name" value="{{ $msg->name }}" required placeholder="例如:李先生" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">分类</label>
                <div class="col-sm-5">
                    <select class="form-control" name="cate_id">
                        @foreach($cateInfo as $key => $value)
                            <option value="{{ $value['id'] }}" @if($msg->cate_id == $value['id']) selected @endif>{{ $value['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">所属</label>
                <div class="col-sm-5">
                    <select class="form-control" name="attr_id" id="attr_box">
                        @foreach($attrInfo as $key => $value)
                            <option value="{{ $value['id'] }}"  @if($msg->attr_id == $value['id']) selected @endif>{{ $value['attr_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">地区</label>
                <input type="hidden" class="pick-area-hidden" name="area" value="">
                <div class="col-sm-5">
                    <a href="javascript:void(0)" class="pick-area pick-area1"  name="{{ $msg->province }}/{{ $msg->city ? $msg->city : '请选择市'}}/{{ $msg->area ? $msg->area : '请选择县'}}">
                    </a>
                    <input type="text" placeholder="详细地址" style="margin-top: 18px;" name="address" value="{{ $msg->address }}" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">手机号</label>
                <div class="col-sm-5">
                    <input name="phone" type="text" value="{{ $msg->phone }}" required class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">标题</label>

                <div class="col-sm-5">
                    <input type="text" name="title" value="{{ $msg->title }}" required class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">详细需求</label>

                <div class="col-sm-5">
                    <textarea name="content" id="" cols="90" rows="10">{{ $msg->content }}</textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">商机价格</label>

                <div class="col-sm-5">
                    <input type="text" name="msg_price" value="{{ $msg->msg_price }}" placeholder="元" required class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">有效期</label>

                <div class="col-sm-5">
                    <input value="{{ date('Y-m-d H:i:s',$msg->validity_time) }}" name="validity_time" class="form-control layer-date"
                           onclick="laydate({istime: true, format: 'YYYY-MM-DD hh:mm:ss'})">
                    <label class="laydate-icon"></label>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <button type="button" class="btn btn-w-m btn-success" onclick="save()">修改</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    $(".pick-area1").pickArea({
    });
    $('select[name=cate_id]').change(function () {
        $.ajax({
            url: "{{ route('admin.message.getAttr') }}",
            type: 'post',
            dataType: 'json',
            data: {
                '_token': "{{ csrf_token() }}",
                'cate_id': $(this).val(),
            },
            success: function (data) {
                console.log(data);
                let html = ``;
                $(data.data).each(function (k, v) {
                    html += `<option value="${v.id}">${v.attr_name}</option>`;
                })
                $('#attr_box').html(html);
            }
        })
    })
    var save = function () {
        var formData = new FormData($('form')[0]);
        $.ajax({
            url: "{{ route('admin.message.update',['msg'=>$msg->id]) }}",
            type: 'post',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.code == 0) {
                    layer.msg(data.msg, {icon: 5})
                } else {
                    layer.msg('修改成功', {icon: 1});
                    setTimeout(function () {
                        window.location.href = "{{ route('admin.message.index') }}";
                    }, 600)
                }
            }
        })
    }
</script>
