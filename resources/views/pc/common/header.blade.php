<div class="bgf">
    <div class="w1200 top_box clear">
        <a href="" class="logo fl">
            <img src="{{ asset('static/pc/images/b_03.jpg') }}" alt="">
        </a>
        <div class="nav_box fl clear">
            <div id="cssmenu" class="fl">
                <ul>
                    <li @if($page_type == 'index') {{ 'class=active' }} @endif>
                        <a href="{{ route('pc.index.index') }}">首页</a>
                    </li>
                    <li @if($page_type == 'rz') {{ 'class=active' }} @endif>
                        <a href="{{ route('pc.rz.rz') }}">品牌入驻</a>
                    </li>
                    <li class="has-sub  @if($page_type == 'productShow') {{ 'active' }} @endif" >
                        <a href="#">产品展示</a>
                        <ul style="display: block;">
                            @foreach(\Illuminate\Support\Facades\DB::table('category')->get() as $key => $value)
                            <li>
                                <a href="{{ route('pc.productShow.index') }}?cate={{ $value->id }}">{{ $value->name }}</a>
                            </li>
                            @endforeach

                        </ul>
                    </li>
                    <li class="has-sub @if($page_type == 'information') {{ 'active' }} @endif">
                        <a href="{{ route('pc.information.index') }}">资讯中心</a>
                    </li>
                    <li class="has-sub @if($page_type == 'question') {{ 'active' }} @endif">
                        <a href="{{ route('pc.question.index') }}">常见问题</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="search_box fl ">
            <div class="oh">
                <input type="text" id="search" value="@yield('search')" class="fl fz16 c3 fl" placeholder="输入关键词">
                <button type="button" onclick="window.location.href='{{ route('pc.index.search') }}?search='+$('#search').val()" class="s_btn fz20 c9 tac fl">
                    <span class="icon-5"></span>
                </button>
            </div>
        </div>
        @if( session('pc') )
            <div class=" fl lh50 h50" style="margin-top: 23px; margin-left: 20px;">
                <a href="{{ route('pc.my.cate') }}" class="fz16 c3">{{ session('pc')->username }}</a>
            </div>
        @else
            <div class="top_login fl">
            <button type="button" class=" fz16 cf" onclick="showMarks(loginHTML);">登录</button>
            </div>
        @endif


    </div>
</div>