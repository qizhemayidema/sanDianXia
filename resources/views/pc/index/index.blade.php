@extends('pc.base.base')

@section('source')
    <link rel="stylesheet" href="{{ asset('static/admin/js/city/css/pick.css') }}">
    <script src="{{ asset('static/admin/js/city/js/pick.js') }}"></script>
    <style>
        .pick-area1{
            width: 100%!important;
        }
        .pick-show{
            border: 0;
            margin-top: 6px;
        }
        .pick-list{
            width: 337px!important;
        }
    </style>
@endsection

@section('title') 首页 @endsection

@section('body')
    <!-- banner -->
    <div class="banner_box">
        <div class="slider single-item">
            @foreach($roll as $key => $value)
            <div>
                <a href="" class="banner" style="background-image: url({{ '/' . $value->url }});"></a>
            </div>
            @endforeach
        </div>
    </div>
    <div class="mb30"></div>

    <div class="w1200 clear">
        <div class="clear mb40">
            <div class="box w850 fl">
                <div class="title bb1 clear">
                    <h3 class="fl fz18 fw9 c3 " style="width: 160px;">最新商机大全</h3>
                    {{--<div class="fl fz14 lh20 red">品牌入驻</div>--}}
                    {{--<div class="fr lh20 fz14">我也要发布信息：<a href="" class="red">发布信息</a></div>--}}
                </div>
                <div class="p20 clear">
                    @if(count($goods))
                    <a href="" class="l_img">
                        <img src="{{ $goods[0]['pic'] }}" alt="">
                    </a>
                    @endif
                    <div class="sj_list">
                        @foreach($goods as $key => $value)
                        <a href="{{ route('pc.store.goods',['goods_id'=>$value['id']]) }}" class="oh bb1">
                            <p class="icon-7 fl red"></p>
                            <div class="fl fz16 c3 oh ">{{ mb_substr($value['title'],0,21) }}</div>
                            <span class="fz16 c9 fr">[{{ date('m-d',$value['create_time']) }}]</span>
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="w320 fr box">
                <div class="title bb1 clear">
                    <h3 class="fl fz18 fw9 c3 ">最新资讯</h3>
                </div>
                <div class="sj_list p20">
                    @foreach($zixun as $key => $value)
                    <a href="{{ route('pc.store.article',['article_id'=>$value['id']]) }}" class="oh bb1">
                        <p class="icon-7 fl c9"></p>
                        <div class="fl fz16 c3 oh  wa">{{ mb_substr($value['title'],0,15) }}</div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="clear mb40">
            <div class="box clear">
                <div class="title bb1 clear">
                    <h3 class="fl fz18 fw9 c3 ">推荐企业</h3>
                </div>
                <div class="p20 oh img_box">
                    @foreach($store as $key => $value)
                    <a href="{{ route('pc.store.index',['store_id'=>$value->id]) }}" class="fl"><img style="width: 386px;height: 76px;" src="{{ $value->banner }}" alt=""></a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="clear mb40">
            <div class="box clear">
                <div class="title bb1 clear">
                    <h3 class="fl fz18 fw9 c3 ">知名商家服务网点</h3>
                </div>
                <div class="p10 oh link_box">
                    @foreach($network as $key => $value)
                        <div class="fl">
                            <span></span>
                            <img src="{{ '/' . $value->url }}" alt="">
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="t1 ">
        <div class="w1200 oh">
            <div class="fl tac t1_list">
                <img src="{{ asset('static/pc/images/y_07.png') }}" alt="">
                <h3>吨位再小</h3>
                <p>小不过我们的服务细致入微</p>
            </div>
            <div class="fl tac t1_list">
                <img src="{{ asset('static/pc/images/y_09.png') }}" alt="">
                <h3>吨位再大</h3>
                <p>大抵不过我们的服务面面俱到</p>
            </div>
            <div class="fl tac t1_list">
                <img src="{{ asset('static/pc/images/y_11.png') }}" alt="">
                <h3>优质服务</h3>
                <p>真诚服务赢得万千信任</p>
            </div>
        </div>
    </div>
    <div class="t2">
        <div class="w1200 oh">
            <div class="t2_title tac p20">
                <h3>您的需求</h3>
                <p class="fz20 c6">拿不定注意？立即填下您的需求，让选型工程师给您最专业的建议</p>
                <span class="fz14 red">留言后将以邮件、短信的方式通知工作人员，3分钟内将电话联系您，请保持电话畅通</span>
            </div>
            <div class="mb30"></div>
            <div class="w1160">
                <div class="sub_list oh">
                    <div class="fl sub_name">称 呼：</div>
                    <div class="fl w340 bgf h50 mr20"><input type="text" name="name" placeholder="请输入您的称呼" class="fz14 c3 tac w100"></div>
                    <div class="oh h50">
                        <div class="fl oh sex_check mr20">
                            <div class="fl  sex_yuan active" data-value="女士">
                                <span class="icon-7"></span>
                            </div>
                            <div class="fz14 c6 h50 fl lh50">女士</div>
                        </div>
                        <div class="fl oh sex_check">
                            <div class="fl  sex_yuan " data-value="先生">
                                <span class="icon-7"></span>
                            </div>
                            <div class="fz14 c6 h50 fl lh50">先生</div>
                        </div>
                    </div>
                </div>
                <div class="sub_list oh">
                    <div class="fl sub_name">联系方式：</div>
                    <div class="fl w340 bgf h50 mr20"><input type="text" name="phone" placeholder="请输入您的手机号" class="fz14 c3 tac w100"></div>
                    <div class="oh h50 fz12 c9 lh50">
                        (必填）
                    </div>
                </div>
                <div class="sub_list oh">
                    <div class="fl sub_name">需求标题：</div>
                    <div class="fl w340 bgf h50 mr20" style="width: 81%;"><input type="text" name="title" placeholder="请输出需求标题" class="fz14 c3 tac w100"></div>
                </div>
                <div class="sub_list oh hook">
                    <div class="fl sub_name">购买时间：</div>
                    <!-- actives  -->
                    <div class="shijian  fl w220  bgf h50 mr20 " data-value="7"><input type="text" readonly="" value="7天内" class="fz14 c9 tac w100 cupo"></div>
                    <div class="shijian  fl w220  bgf h50 mr20" data-value="30"><input type="text" readonly="" value="一个月内" class="fz14 c9 tac w100 cupo"></div>
                    <div class="shijian  fl w220  bgf h50 mr20" data-value="90"><input type="text" readonly="" value="1-3个月内" class="fz14 c9 tac w100 cupo"></div>
                    <div class="shijian  fl w220  bgf h50 mr20" data-value="120"><input type="text" readonly="" value="3个月以上" class="fz14 c9 tac w100 cupo"></div>
                </div>
                <div class="sub_list ">
                    <div class="fl sub_name">使用地点：</div>
                    <div class="fl w340 bgf h50 mr20">
                        <a href="javascript:void(0)" class="pick-area pick-area1">
                        </a>
                    </div>
                </div>
                <div class="sub_list oh">
                    <div class="fl sub_name"></div>
                    <div class="fl w340 bgf h50 mr20">
                        <div class="fl w340 bgf h50 mr20"><input type="text" name="address" placeholder="请写出你的详细地址" class="fz14 c3 tac w100"></div>

                    </div>
                </div>
                <div class="sub_list oh mb40">
                    <div class="fl sub_name">详细需求：</div>
                    <div class="bgf fl w940">
                        <div class="p20">
                            <textarea class="textarea" name="content" rows="10" placeholder="填写详细需求：使用场景、吨位、跨度、起升高度..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="form_btn tac oh">
                    <button type="button" onclick="save()">提交需求</button>
                </div>
            </div>
        </div>
    </div>


    <script>
        $(".pick-area1").pickArea();

        // banner
        $('.single-item').slick({
            dots: true,
            speed: 500,
            arrows: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 3000
        });
        $(".cp_list:nth-child(4n)").css({ 'margin-right': 0 });
        $(".sex_check").click(function() { //选择性别
            $(".sex_yuan").removeClass('active');
            $(this).find('.sex_yuan').addClass('active');
        });
        $(".hook .w220").click(function() { //单选
            $(this).parents('.hook').find('.w220').removeClass('actives');
            $(this).addClass('actives');
        })

        var save = function()
        {
            var name = $('input[name=name]').val() + $('.sex_yuan.active').data('value');
            var phone = $('input[name=phone]').val()
            var time = $('.shijian.actives').data('value');
            var area = $('.pick-area-hidden').val()
            var address = $('input[name=address]').val()
            var content = $('textarea[name=content]').val()
            var title = $('input[name=title]').val()

            if (!$('input[name=name]').val() || !title || !phone || !time || !area || !address || !content) {
                layer.msg('请将表单填写完整')
            }
            $.ajax({
                url:"{{ route('pc.message.save') }}",
                data:{
                    name : name,
                    phone : phone,
                    time : time,
                    area : area ,
                    address : address,
                    content : content ,
                    title : title,
                    _token : "{{ csrf_token() }}",
                },
                type:'post',
                dataType:'json',
                success:function(data){
                    if (data.code == 0) {
                        layer.msg(data.msg, {icon: 5})
                    } else {
                        layer.msg('发布成功,请您耐心等待消息', {icon: 1});
                        setTimeout(function () {
                            window.location.reload()
                        }, 1500)
                    }
                }
            })
        }
    </script>
@endsection