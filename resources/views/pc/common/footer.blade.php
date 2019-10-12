<div class="footer">
    <div class="w1200">
        <div class="footer_top oh">
            <div class="fl" style="margin-top: 18px;">
                <div class="telOrTime" style="margin-bottom: 15px;">
                    <span class="icon icon-uniE900 fz24" style="color: #879fb7;"></span>
                    <span class="fz14 cf">联系电话：{{ $config->phone }}</span>
                </div>
                <div class="telOrTime">
                    <span class="icon icon-4 fz24" style="color: #879fb7;"></span>
                    <span class="fz14 cf">上班时间：{{ $config->start_time }}-{{ $config->end_time }}</span>
                </div>
            </div>
            <div class="fr">
                <img src="{{ '/' . $config->qrCode }}" alt="" class="code">
                <p class="fz14 cf lh30 tac" style="opacity: .5">扫码联系客服</p>
            </div>
        </div>
    </div>
    <div class="bq">
        <p class="fz14 cf tac">
            机械超人网备案号：{{ $config->icp }}增值电信业务经营许可证：{{ $config->dianXin }} <br>
            版权所有©Copyright 2019 All Rights Reserved.本站所发布的内容，未经许可，不得转载
        </p>
    </div>
</div>