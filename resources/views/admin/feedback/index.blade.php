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
                        <th style="text-align: center;">反馈内容</th>
                        <th style="text-align: center;">反馈时间</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($res as $key => $value)
                        <tr>
                            <td>{{ $value->content }}</td>
                            <td>{{ date('Y-m-d H:i:s',$value->create_time) }}</td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div style="float: right;">
                {{ $res->links() }}
            </div>
        </div>
    </div>
</div>