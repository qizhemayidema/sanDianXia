@include('admin.common.source')
<div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">分类名称</label>

                <div class="col-sm-5">
                    <input name="cate_name" value="{{ $cate_info['name'] }}" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">属性名称</label>
                <div class="col-sm-5">
                    @foreach($attr_info as $key => $value)
                    <div class="attr_box">
                        <input type="text" name="attr_set[{{ $value['id'] }}]" class="form-control" style="width: 30%;margin-bottom: 10px;margin-top: 10px;display: inline-block;" value="{{ $value['attr_name'] }}">
                        <input class="btn btn-outline btn-danger" style="margin-bottom:5px;" value="删除" onclick="delete_one(this,{{ $value['id'] }})" type="button">
                    </div>
                    @endforeach
                    <textarea name="new_attr_value" id="" style="width: 100%;height: 80px;" placeholder="新增属性,每行一个标签"></textarea>

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
    var delete_one = function(_this,attr_id){
        $.ajax({
            url:"{{ route('admin.cate.deleteAttr') }}",
            type:'post',
            dataType:'json',
            data:{
                attr_id : attr_id,
                _token : '{{ csrf_token() }}',
            },
            success:function(data){
                if (data.code == 0){
                    layer.msg(data.msg)
                } else{
                    $(_this).parents('.attr_box').remove();
                }
            }
        })
    }
    var save = function(){
        var formData = new FormData($('form')[0]);
        $.ajax({
            url:"{{ route('admin.cate.update',['cate_id'=>$cate_info['id']]) }}",
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
                        window.location.href = "{{ route('admin.cate.index') }}";
                    },600)
                }
            }
        })
    }
</script>
