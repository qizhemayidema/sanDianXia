@include('admin.common.source')
<div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">分类名称</label>

                <div class="col-sm-5">
                    <input name="cate_name" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">属性名称</label>

                <div class="col-sm-5">
                    <textarea name="attr_values" placeholder="每行是一个属性" id="" cols="80" rows="10"></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                    <button type="button" class="btn btn-w-m btn-success" onclick="save()">添加</button>
                </div>
            </div>
        </form>
    </div>

</div>

<script>
    var save = function(){
        var formData = new FormData($('form')[0]);
        $.ajax({
            url:"{{ route('admin.cate.save') }}",
            type:'post',
            dataType:'json',
            data:formData,
            processData:false,
            contentType:false,
            success:function(data){
                if (data.code == 0){
                    layer.msg(data.msg,{icon:5})
                } else{
                    layer.msg('添加成功',{icon:1});
                    setTimeout(function(){
                        window.location.href = "{{ route('admin.cate.index') }}";
                    },600)
                }
            }
        })
    }
</script>
