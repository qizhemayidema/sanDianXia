@extends('pc.myBase.base')

@section('title') 分类管理 @endsection

@section('source')
    <link rel="stylesheet" href="https://cdn.staticfile.org/twitter-bootstrap/3.3.7/css/bootstrap.min.css">

@endsection


@section('content')
    <!-- 我的发布 -->
    <div class="mybox_R_one hook" style="display: block;">
        <div class="my_b_r_type my_b_r_type1">
            <span class="">分类管理</span>
        </div>
        @if(!$data)
        <div class="w100">
            <div class="zanwu">暂无数据</div>
        </div>
        @endif
        <div class="tac" style="margin-top: 20px;">
            <div class="oh lh40 fz14 c3">
                <div class="fl tal" style="width: 40%; text-indent: 25px;">分类标题</div>
                <div class="fl tac" style="width: 50%;">顶部导航显示</div>
                <div class="fl tac" style="width: auto;">操作</div>
            </div>
            <table class="table table-striped classTable">
                <tbody>
                @foreach($data as $key => $value)
                <tr data-value="{{ $value->id }}">
                    <td style="vertical-align:middle;" class="tal" width="50%">
                        <input type="text" name="cate" style="height:100%;border: 1px solid #ccc;" value="{{ $value->name }}" id="">

                    </td>
                    <td >
                        <div class="oh open_box">
                            <p class="fl @if($value->is_banner == 0) active @endif" onclick="changeStatus(this,0)">关</p>
                            <p class="fl @if($value->is_banner == 1) active @endif" onclick="changeStatus(this,1)">开</p>
                        </div>
                    </td>
                    <td style="vertical-align:middle;"  ><span class=" cupo blue" onclick="del('{{ $value->id }}')">删除</span></td>
                </tr>
                @endforeach
                </tbody>
            </table>
            <div class="addBtn tal">
                <button type="button">添加</button>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>

        $(".open_box p").click(function(event) {
            $(this).siblings().removeClass('active');
            $(this).addClass('active');
        });
        var changeStatus = function(_this,status){
            var cate_id = $(_this).parents('tr').data('value');
            $.ajax({
                url : "{{ route('pc.my.cate.changeStatus') }}",
                type: "post",
                dataType : "json",
                data : {
                    cate_id : cate_id,
                    status : status,
                    _token : "{{ csrf_token() }}"
                },
                success : function(data){

                }
            })
        }

        var del = function(cate_id){
            $.ajax({
                url : "{{ route('pc.my.cate.delete') }}",
                type: "post",
                dataType : "json",
                data : {
                    cate_id : cate_id,
                    _token : "{{ csrf_token() }}"
                },
                success : function(data){
                    if (data.code == 1){
                        layer.msg('删除成功')
                        setTimeout(function () {
                            window.location.reload()
                        },1500)
                    } else{
                        layer.msg(data.msg)
                    }
                }
            })
        }

        $('.addBtn button').on('click',function(){
            layer.open({
                title:'请填写分类名称',
                type: 1,
                content:`<input type="text" id="newCate" style="margin:15px;border:1px solid #ccc">`,
                btn:['添加', '取消'],
                yes:function (index, layero) {
                    var new_cate = $('#newCate').val();
                    if (!new_cate){
                        layer.msg('名称不能为空')
                    }
                    $.ajax({
                        url : "{{ route('pc.my.cate.save') }}",
                        type: "post",
                        dataType : "json",
                        data : {
                            cate : new_cate,
                            _token : "{{ csrf_token() }}"
                        },
                        success : function(data){
                            console.log(data)
                            if (data.code == 1){
                                layer.msg('添加成功')
                                setTimeout(function () {
                                    window.location.reload()
                                },1500)
                            } else{
                                layer.msg(data.msg)
                            }
                        }
                    })
                    // layer.close(index)
                }
            });
        })

        $('input[name=cate]').on('blur',function () {
            var cate_id = $(this).parents('tr').data('value');
            var value = $(this).val()
            $.ajax({
                url : "{{ route('pc.my.cate.update') }}",
                type: "post",
                dataType : "json",
                data : {
                    cate_id : cate_id,
                    cate : value,
                    _token : "{{ csrf_token() }}"
                },
                success : function(data){
                    console.log(data)
                    if (data.code == 1){
                        layer.msg('修改成功')

                    } else{
                        layer.msg(data.msg)
                    }
                }
            })
        })
    </script>
@endsection