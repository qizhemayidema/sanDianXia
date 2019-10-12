@yield('body')
<div class="h50"></div>
<div class="footer flex bt1">
    <a href="{{ route('index.index') }}" class="footer_a tac flex_1 @if(!isset($page_type) || $page_type == 'index') active @endif">
        <div>
            <span class="icon--1"></span>
        </div>
        <p>商机咨询</p>
    </a>
    <a href="{{ route('index.my_msg.index') }}" class="footer_a tac flex_1 @if($page_type == 'my_msg') active @endif">
        <div>
            <span class="icon-16"></span>
        </div>
        <p>我的商机</p>
    </a>
    <a href="{{ route('index.store.index') }}" class="footer_a tac flex_1 @if($page_type == 'store') active @endif">
        <div>
            <span class="icon-uniE900"></span>
        </div>
        <p>企业店铺</p>
    </a>
    <a href="{{ route('index.user.index') }}" class="footer_a tac flex_1 @if($page_type == 'user') active @endif">
        <div>
            <span class="icon-8"></span>
        </div>
        <p>会员中心</p>
    </a>
</div>