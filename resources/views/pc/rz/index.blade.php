@extends('pc.base.base')

@section('title') 品牌入驻 @endsection

@section('body')
    <!-- banner -->
    <div class="infoBanner" style="background-image: url({{ asset('static/pc/images/rz_02.jpg') }});">
    </div>
    <!--  -->
    <div class="w1200">
        <div class="rz_title tac">
            <h3>入驻优势</h3>
            <p>Residence Advantage</p>
        </div>
        <div class="clear mb30">
            <div class="rz_list fl tac">
                <img src="{{ asset('static/pc/images/rz_05.jpg') }}" alt="">
                <p>增加品牌曝光量<br>抢占客户心智</p>
            </div>
            <div class="rz_list fl tac">
                <img src="{{ asset('static/pc/images/rz_07.jpg') }}" alt="">
                <p>增加品牌曝光量<br>抢占客户心智</p>
            </div>
            <div class="rz_list fl tac">
                <img src="{{ asset('static/pc/images/rz_09.jpg') }}" alt="">
                <p>增加品牌曝光量<br>抢占客户心智</p>
            </div>
            <div class="rz_list fl tac" style="margin-right: 0;">
                <img src="{{ asset('static/pc/images/rz_11.jpg') }}" alt="">
                <p>增加品牌曝光量<br>抢占客户心智</p>
            </div>
        </div>
    </div>
    <!--  -->
    <div class="t3 oh">
        <div class="tac t3_title">
            <h3>同行都来了，你还在等什么?</h3>
            <p>机械超人平台每日发布个<span class="red">652</span>新询价单，<span class="red">53</span>家新企业入驻</p>
        </div>
        <div class="tac">
            <button type="button" class="rz_btn cupo">低至{{ $service->money ?? '' }}元，即可入驻</button>
        </div>
    </div>
    <!--  -->
    <div class="w1200">
        <div class="rz_title tac">
            <h3>业务介绍</h3>
            <p>Business introduction</p>
            <div class="fz14 c9">机械超人是围绕起重设备的销售、采购、使用管理和起重设备技术服务的互联网+起重专业电子商务平台，通过对专业信息的手机整理，存储和反馈，为整个起重设备行业提供丰富的信息源，
                是您的决策更合理，更科学，为您的产品提供更开放的销售渠道。</div>
        </div>
        <div class="clear mb30">
            <div class="yw_list fl tac">
                <img src="{{ asset('static/pc/images/rz_20.jpg') }}" alt="">
                <h3 class="fz18 c3">全网品牌宣传</h3>
                <p class="fz14 c9">覆盖网络主流媒体，博客，社交
                    平台,影音综艺，多层次展现，让
                    您的品牌世人皆知。</p>
            </div>
            <div class="yw_list fl tac">
                <img src="{{ asset('static/pc/images/rz_22.jpg') }}" alt="">
                <h3 class="fz18 c3">商机靠谱采购</h3>
                <p class="fz14 c9">精准投放带来的优质采购客户，
                    近期内就会下单购买，做好售
                    前服务，稳拿订单。</p>
            </div>
            <div class="yw_list fl tac">
                <img src="{{ asset('static/pc/images/rz_24.jpg') }}" alt="">
                <h3 class="fz18 c3">精准线上营销</h3>
                <p class="fz14 c9">大数据分析，精准品牌展示，
                    多维互动，让陌生客户记住你
                    让想找你的客户找到你。</p>
            </div>
            <div class="yw_list fl tac">
                <img src="{{ asset('static/pc/images/rz_26.jpg') }}" alt="">
                <h3 class="fz18 c3">推送实时沟通</h3>
                <p class="fz14 c9">每日实时推送商机信息到您的
                    手机，让您手机在手，不用东
                    奔西走商机全有，订单不断。</p>
            </div>
        </div>
        <!--  -->
        <div class="rz_title tac">
            <h3>入驻流程</h3>
            <p>Residence process</p>
        </div>
        <div class="clear mb30">
            <div class="lc_list">
                <div class="lc_list_tltle mb30">申请入驻</div>
                <p class="tac">加客服微信<br>chaoren3036</p>
            </div>
            <div class="lc_list">
                <div class="lc_list_tltle mb30">提交资料，审核</div>
                <p class="tac">准备企业相关资料<br>
                    发送到指定邮箱<br>
                    1669199967@qq.com</p>
            </div>
            <div class="lc_list">
                <div class="lc_list_tltle mb30">审核通过</div>
                <p class="tac">审核通过，企业<br>
                    店铺开通成功，<br>
                    享平台权益</p>
            </div>
            <div class="lc_list">
                <div class="lc_list_tltle mb30">上传产品，资料</div>
                <p class="tac">平台专员帮你上传<br>
                    企业相关产品，资<br>
                    料，装修企业店铺</p>
            </div>
            <div class="lc_list">
                <div class="lc_list_tltle mb30">全网推广</div>
                <p class="tac">全网推广企业店铺<br>
                    增加订单量</p>
            </div>
        </div>
    </div>
@endsection