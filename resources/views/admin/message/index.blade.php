@include('admin.common.source')
<div class="col-sm-12">
    <div class="ibox float-e-margins">
        <div class="ibox-title">
            <h5>
                <button type="button" onclick="window.location.href='{{ route('admin.message.add') }}'"
                        class="btn btn-w-m btn-primary">发布商机
                </button>
            </h5>

        </div>
        <div class="ibox-content">
            <div class="example">

                <table class="table table-bordered table-hover text-center">
                    <thead>
                    <tr class="text-center">
                        <th style="text-align: center;">id</th>
                        <th style="text-align: center;">所属</th>
                        <th style="text-align: center;">标题</th>
                        <th style="text-align: center;">手机号</th>
                        <th style="text-align: center;">接单次数</th>
                        <th style="text-align: center;">有效期</th>
                        <th style="text-align: center;">审核</th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->attr_name }}</td>
                        <td>{{ $value->title }}</td>
                        <td>{{ $value->phone }}</td>
                        <td>{{ $value->accept_sum }}</td>
                        <td>{{ date('Y-m-d H:i:s',$value->validity_time) }}</td>
                        <td>
                            @if($value->status == 0)
                                <button class="btn btn-w-m btn-info" onclick="checkStatus('{{ route('admin.message.check_status',['msg'=>$value->id]) }}')">未审核</button>
                            @elseif($value->status == 1)
                                <button class="btn btn-w-m btn-default" onclick="checkStatus('{{ route('admin.message.check_status',['msg'=>$value->id]) }}')">未通过</button>
                            @else
                                <button class="btn btn-w-m btn-primary" onclick="checkStatus('{{ route('admin.message.check_status',['msg'=>$value->id]) }}')">已通过</button>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle" aria-expanded="false">操作 <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">

                                    <li><a href="{{ route('admin.message.edit',['msg'=>$value->id]) }}" class="font-bold">修改</a>
                                    </li>

                                    <li><a href="javascript:void(0);" onclick="removeCate(this,'{{ route('admin.message.delete',['msg'=>$value->id]) }}')">删除</a>
                                    </li>
                                </ul>
                            </div>
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

    checkStatus = function(url) {
        layer.open({
            type:2,
            content : url,
            area:['300px','400px;'],
            title:'审核',
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