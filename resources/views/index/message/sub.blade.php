@extends('index.common.base')
@section('body')
    <div class="bgf">
        <div class="p10_3">
            <div class="fz14 c9 mb10"><span class="red">提示：</span>选择您经<span class="red">营的产品、主营业务</span>或<span class="red">行业关键词</span>,系统将第一时间将相关商机信息推送给您。</div>
            <div class="text mb10">
                <select name="cate" style="width: 100%;">
                    @foreach($cate as $key => $value)
                    <option @if($userSelect && $userSelect['cate_id'] == $value['id']) selected @endif  value="{{ $value['id'] }}">{{ $value['name'] }}</option>
                    @endforeach
                </select>
            </div>
            <div class="text mb10">
                <select name="attr" id="attr_box" style="width: 100%;">
                    @foreach($attr as $key => $value)
                    <option  @if($userSelect && $userSelect['id'] == $value['id']) selected @endif  value="{{ $value['id'] }}">{{ $value['attr_name'] }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="submit_box">
            <button type="button" onclick="save()">提交保存</button>
        </div>
    </div>
    <script>
        $(function(){
            $('select[name=cate]').change(function(){
                $.ajax({
                    url:"{{ route('index.message.attr') }}",
                    type:'post',
                    dataType:'json',
                    data:{
                        _token : "{{ csrf_token() }}",
                        cate_id : $(this).val()
                    },
                    success:function(data){
                        let html = ``
                        $(data.data).each(function(k,v){
                            html += `<option value="${v.id}">${v.attr_name}</option>`
                        })
                        $('#attr_box').html(html)
                    }
                })
            })
        })

        var save = function(){
            var attr_id = $('select[name=attr]').val()
            $.ajax({
                url:"{{ route('index.message.save_attr') }}",
                type:"post",
                dataType:'json',
                data:{
                    _token : "{{ csrf_token() }}",
                    attr_id : attr_id
                },
                success:function(data){
                    if (data.code == 1){
                        layer.msg('修改成功')
                        setTimeout(function(){
                            window.location.reload()
                        },800)
                    }else{
                        layer.msg(data.msg)
                    }
                }
            })
        }
    </script>
@endsection