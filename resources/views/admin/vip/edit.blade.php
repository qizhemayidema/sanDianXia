@include('admin.common.source')
<div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">会员名称</label>

                <div class="col-sm-5">
                    <input name="name" value="{{ $vip_id['name'] }}" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">会员价格 / 年</label>

                <div class="col-sm-5">
                    <input name="money" value="{{ $vip_id['money'] }}" type="text" placeholder="RMB(元)" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label">商机折扣</label>

                <div class="col-sm-5">
                    <input name="discount" value="{{ $vip_id['discount'] }}" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">提前接收商机推送N秒</label>

                <div class="col-sm-5">
                    <input name="precedence" value="{{ $vip_id['precedence'] }}" type="text" class="form-control">
                    <span class="help-block m-b-none">注 : 普通用户在{{ $normalUserPushTime }}秒后接收推送,所以请不要超过这个数值</span>
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
    var save = function(){
        var formData = new FormData($('form')[0]);
        $.ajax({
            url:"{{ route('admin.vip.update',['vip_id'=>$vip_id['id']]) }}",
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
                        window.location.href = "{{ route('admin.vip.index') }}";
                    },600)
                }
            }
        })
    }
</script>
