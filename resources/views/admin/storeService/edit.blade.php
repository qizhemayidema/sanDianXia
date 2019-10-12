@include('admin.common.source')
<div class="col-sm-12">
    <div class="ibox-content">
        <form action="" class="form-horizontal">
            {{ csrf_field() }}
            <div class="form-group">
                <label class="col-sm-3 control-label">店铺服务名称</label>

                <div class="col-sm-5">
                    <input name="name" value="{{ $service['name'] }}" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">价格/年</label>

                <div class="col-sm-5">
                    <input name="money" value="{{ $service['money'] }}" type="text" class="form-control">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">是否限制vip购买
                    <input type="checkbox" name="is_vip" value="1"
                           @if($service['vip_id'])
                               checked
                           @endif
                    >
                </label>

                <div class="col-sm-5" id="vip_box"
                     @if(!$service['vip_id'])
                     style="display: none;"
                    @endif
                >
                    <select class="form-control m-b" name="vip_id">
                        @foreach($vip as $key => $value)
                            <option value="{{ $value->id }}" @if($service['id'] == $value->id) selected @endif>{{ $value->name }}</option>
                        @endforeach
                    </select>
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
            url:"{{ route('admin.storeService.update',['service_id'=>$service['id']]) }}",
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
                        window.location.href = "{{ route('admin.storeService.index') }}";
                    },600)
                }
            }
        })
    }
    $(function(){
        $('input[name=is_vip]').change(function(){
            if($(this).prop('checked')){
                $('#vip_box').css('display','block');
            }else{
                $('#vip_box').css('display','none');
            }
        })
    })
</script>
