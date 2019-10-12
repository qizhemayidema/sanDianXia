@include('admin.common.source')
<div class="col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">

        </div>
        <div class="ibox-content">
            <div class="example">

                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr class="text-center">
                        <th style="text-align: center;">分类</th>
                        <th style="text-align: center;">所属</th>
                        <th style="text-align: center;">名称</th>
                        <th style="text-align: center;">封面</th>
                        <th style="text-align: center;">介绍</th>
                        <th style="text-align: center;">状态</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                        <tr>
                            <td>{{ $value->cate_name }}</td>
                            <td>{{ $value->attr_name }}</td>
                            <td><a target="_blank" href="{{ route('pc.store.goods',['goods_id'=>$value->id]) }}">{{ $value->title }}</a></td>
                            <td><img style="width: 40px;" src="{{ '/' . $value->pic }}" alt=""></td>
                            <td>{{ $value->desc }}</td>
                            <td>
                                @if($value->status == 0)
                                    <button class="btn btn-w-m btn-default" onclick="checkStatus(this,1,'{{ $value->id }}')">已封禁</button>
                                @elseif($value->status == 1)
                                    <button class="btn btn-w-m btn-primary" onclick="checkStatus(this,0,'{{ $value->id }}')">已通过</button>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
                {{ $data->links() }}
            </div>
        </div>
    </div>
</div>
<script>

    checkStatus = function(_this,old_status,article_id) {
        $.ajax({
            url: '{{ route('admin.goods.check') }}',
            type: 'post',
            dataType: 'json',
            data:{
                goods_id : article_id,
                _token:'{{ csrf_token() }}',
            },
            success: function (data) {
                if (data.code == 0) {
                    layer.msg(data.msg,{icon: 5})
                } else {
                    layer.msg('修改成功')
                    let str = ``
                    if (old_status == 0){
                        str = `<button class="btn btn-w-m btn-default" onclick="checkStatus(this,1,'${article_id}')">已封禁</button>`
                    } else{
                        str = `<button class="btn btn-w-m btn-primary" onclick="checkStatus(this,0,'${article_id}')">已通过</button>`
                    }
                    $(_this).parents('td').html(str)
                }
            }
        })
    }


    var removeCate = function (_this, url) {
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data:{
                _token:'{{ csrf_token() }}',
            },
            success: function (data) {
                if (data.code == 0) {
                    layer.msg(data.msg,{icon: 5})
                } else {
                    layer.msg('删除成功',{icon : 1})
                    $(_this).parents('tr').remove();
                }
            }
        })
    }
</script>