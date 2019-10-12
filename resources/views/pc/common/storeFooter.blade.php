<div class="t2">
    <div class="w1200 oh">
        <div class="t2_title tac p20">
            <a name="table"></a>
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
@include('pc.common.footer')

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
        var store_id = '{{ $store->id }}'
        var goods_id = '{{ isset($goods) ? $goods->id : 0 }}'

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
                store_id : store_id,
                goods_id : goods_id,
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