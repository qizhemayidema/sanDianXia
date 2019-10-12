<style>
    .table tr{
        text-align: center;
    }
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th{
        vertical-align: middle;
    }
    .table button{
        border-radius: 5px;
        color: #fff;
        background: #50cc99;
        width: 80px;
        height: 40px;
    }
    .table{
        margin-bottom: 0;
    }
</style>
@extends('index.common.basic')

@section('body')
    <div class="bgf p10_3 mb10 bb1">
        <div class="flex lh30">
            <div class="flex_1 red fz16">金牌会员服务</div>
            <div class="tar">
                <div class="flex">
                    @if($vip)
                        <span class="red fz14" style="padding-right: 10px;">{{ $vip['name'] }}</span>
                        <p class="fz14 c3">{{ $vip['money'] }}元/年</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="bgf p10_3 mb10 bb1">
        <div class="flex lh30">
            <div class="flex_1 red fz16">企业店铺服务</div>
            <div class="tar">
                @if($service)
                <div class="flex">
                    <span class="red fz12" style="padding-right: 10px;">{{ $service['name'] }}</span>
                    <p class="fz12 c3">{{ $service['money'] }}元/年</p>
                </div>
                <div class="flex">
                    <span class="fz12" style="padding-right: 10px;">账号</span>
                    <p class="fz12 c3"> {{ $store['username'] }}</p>
                </div>
                    <div class="flex">
                        <span class="fz12" style="padding-right: 10px;">密码</span>
                        <p class="fz12 c3"> {{ $store['password'] }}</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection