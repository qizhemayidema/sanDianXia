@foreach($message as $key => $msg)
    <a href="{{ route('index.message.info',['msg_id'=>$msg->id]) }}" class="index_list mb10 bgf">
        <div class="flex index_list_title">
            <h3 class="flex_1 oh1 lh30">{{ $msg->title }}</h3>
            <span class="fz12 c9 lh30">{{ date("Y-m-d H:i:s",$msg->create_time) }}</span>
        </div>
        <div class="fz14 c3 lh30">
            收货地址：{{ $msg->province }} {{ $msg->city }} {{ $msg->area }} {{ $msg->address }}</div>
        <div class="fz14 c9 bb1 pb10">描述：{{ $msg->content }}
        </div>
        <div class="flex">
            <div class="index_list_progress flex_1 bgf4">
                <div style="width: {{ 25 * $msg->accept_sum }}%;"></div>
            </div>
            <div class="fz14 ca" style="line-height: 26px;">{{ $msg->accept_sum }}/4</div>
        </div>
        <div class="fz14 c9">{{ $msg->accept_sum }}人参与</div>
    </a>
@endforeach