@include('admin.common.source')
<body class="pace-done mini-navbar"><div class="pace  pace-inactive"><div class="pace-progress" data-progress-text="100%" data-progress="99" style="width: 100%;">
        <div class="pace-progress-inner"></div>
    </div>
    <div class="pace-activity"></div></div><div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $msg->id }}">
            <div class="form-group">
                <label class="col-sm-3 control-label">状态</label>
                <div class="col-sm-5">
                    <select class="form-control" name="status">
                        <option value="0" @if($msg->status == 0) selected @endif>未审核</option>
                        <option value="2" @if($msg->status == 2) selected @endif>已通过</option>
                        <option value="1" @if($msg->status == 1) selected @endif>未通过</option>
                    </select>
                </div>
            </div>
            <div class="form-group" id="cate_list"  @if($msg->status != 2) style="display: none;"  @endif>
                <label class="col-sm-3 control-label">分类</label>
                <div class="col-sm-5">
                    <select class="form-control" name="cate">
                        @foreach($cate as $key => $value)
                        <option value="{{ $value['id'] }}" @if($user_attr && $value['id'] == $user_attr['cate_id']) selected @endif>{{ $value['name'] }}</option>
                            @endforeach
                    </select>
                    <select id="attr_box" class="form-control" name="attr">
                        @foreach($attr as $key => $value)
                            <option value="{{ $value['id'] }}"  @if($user_attr && $value['id'] == $user_attr['id']) selected @endif>{{ $value['attr_name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <button type="button" class="btn btn-w-m btn-success" onclick="save()">审核</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
   $(function(){
       $('select[name=status]').change(function () {
           if ($(this).val() == 2){
               $("#cate_list").css('display','block');
           } else{
               $("#cate_list").css('display','none');
           }
       })
       $('select[name=cate]').change(function () {
           $.ajax({
               url: "{{ route('admin.message.getAttr') }}",
               type: 'post',
               dataType: 'json',
               data: {
                   '_token': '{{ csrf_token() }}',
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
   })
    var save = function () {
        var formData = new FormData($('form')[0]);
        $.ajax({
            url: "{{ route('admin.message.change_status') }}",
            type: 'post',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (data) {
                if (data.code == 0) {
                    layer.msg(data.msg, {icon: 5})
                } else {
                    layer.msg('审核成功', {icon: 1});
                    setTimeout(function () {

                        var mylayer= parent.layer.getFrameIndex(window.name);

                        parent.layer.close(mylayer);
                        parent.location.reload();
                    }, 600)
                }
            }
        })
    }
</script><input type="hidden" class="pick-area-hidden" value=""><input type="hidden" class="pick-area-dom" value="">
</body>