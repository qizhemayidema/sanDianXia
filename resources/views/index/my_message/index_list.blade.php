@foreach($msg as $key => $value)
    <a href="{{ route('index.message.info',['msg_id'=>$value->id]) }}" class="index_list mb10 bgf">
        <div class="flex index_list_title">
            <h3 class="flex_1 oh1 lh30 c3">采购人：{{ $value->name }} <span class="fz12"></span></h3>
            {{--<span class="fz14 ca lh30">已解决</span>--}}
        </div>
        <div class="fz14 c9 lh30">收货地址：({{ $value->province }} {{ $value->city }} {{ $value->area }} {{ $value->address }})</div>
        <div class="fz14 c6">描述：{{ $value->content }}
        </div>
    </a>
@endforeach