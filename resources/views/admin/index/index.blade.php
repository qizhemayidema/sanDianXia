<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <title>主页</title>

    <link href="favicon.ico" rel="shortcut icon">
    <link href="{{ \Illuminate\Support\Facades\URL::asset('static/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ \Illuminate\Support\Facades\URL::asset('static/admin/css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ \Illuminate\Support\Facades\URL::asset('static/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ \Illuminate\Support\Facades\URL::asset('static/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
<div id="wrapper">
    <!--左侧导航开始-->
    <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="nav-close"><i class="fa fa-times-circle"></i>
        </div>
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element">
                        {{--<span><img alt="image" class="img-circle" src="img/profile_small.jpg" /></span>--}}
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="clear">
                               <span class="block m-t-xs"><strong class="font-bold">{{ session('admin.manager')['user_name'] }}</strong></span>
                                <span class="text-muted text-xs block">超级管理员<b class="caret"></b></span>
                                </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            {{--<li><a class="J_menuItem" href="form_avatar.html">修改头像</a>--}}
                            {{--</li>--}}
                            {{--<li><a class="J_menuItem" href="profile.html">个人资料</a>--}}
                            {{--</li>--}}
                            {{--<li class="divider"></li>--}}
                            <li><a href="{{ route('admin.login.logout') }}">安全退出</a>
                            </li>
                        </ul>
                    </div>
                    <div class="logo-element">后台
                    </div>
                </li>
                <li>
                    <a href="#">
                        <i class="fa fa-home"></i>
                        <span class="nav-label">商机</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.cate.index') }}" data-index="0">分类</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.message.index') }}" data-index="0">商机</a>
                        </li>
                    </ul>

                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-cog"></i>
                        <span class="nav-label">设置</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.vip.index') }}" data-index="0">vip</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.storeService.index') }}">店铺服务</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.roll.index') }}">轮播图</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.network.index') }}">服务网点</a>
                        </li>
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.config.index') }}">网站配置</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <span class="nav-label">查看</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.feedback.index') }}" data-index="0">意见反馈</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <i class="glyphicon glyphicon-ok"></i>
                        <span class="nav-label">审核</span>
                        <span class="fa arrow"></span>
                    </a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a class="J_menuItem" href="{{ route('admin.article.index') }}?type=1" data-index="0">资讯</a>
                            <a class="J_menuItem" href="{{ route('admin.article.index') }}?type=2" data-index="0">常见问题</a>
                            <a class="J_menuItem" href="{{ route('admin.goods.index') }}" data-index="0">店铺商品</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
    <!--左侧导航结束-->
    <!--右侧部分开始-->
    <div id="page-wrapper" class="gray-bg dashbard-1">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header"><a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                    <form role="search" class="navbar-form-custom" method="post">
                    </form>
                </div>
            </nav>
        </div>
        <div class="row content-tabs">
            <button class="roll-nav roll-left J_tabLeft"><i class="fa fa-backward"></i>
            </button>
            <nav class="page-tabs J_menuTabs">
                <div class="page-tabs-content">
                    <a href="javascript:;" class="active J_menuTab" data-id="index_v1.html">首页</a>
                </div>
            </nav>
            <button class="roll-nav roll-right J_tabRight"><i class="fa fa-forward"></i>
            </button>
            <div class="btn-group roll-nav roll-right">
                <button class="dropdown J_tabClose" data-toggle="dropdown">关闭操作<span class="caret"></span>

                </button>
                <ul role="menu" class="dropdown-menu dropdown-menu-right">
                    <li class="J_tabShowActive"><a>定位当前选项卡</a>
                    </li>
                    <li class="divider"></li>
                    <li class="J_tabCloseAll"><a>关闭全部选项卡</a>
                    </li>
                    <li class="J_tabCloseOther"><a>关闭其他选项卡</a>
                    </li>
                </ul>
            </div>
            <a href="{{ route('admin.login.logout') }}" class="roll-nav roll-right J_tabExit"><i class="fa fa fa-sign-out"></i> 退出</a>
        </div>
        <div class="row J_mainContent" id="content-main">
            <iframe class="J_iframe" name="iframe0" width="100%" height="100%" src="{{ route('admin.homePage') }}" frameborder="0" seamless></iframe>
        </div>
    </div>
    <!--右侧部分结束-->
</div>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/jquery.min.js?v=2.1.4') }}"></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/plugins/layer/layer.min.js') }}"></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/hplus.js?v=4.1.0') }}"></script>
<script src="{{ \Illuminate\Support\Facades\URL::asset('static/admin/js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('static/admin/js/contabs.js') }}" type="text/javascript"></script>

</body>

</html>
