var url = "http://wy.symhw.net";
var timeout = '6000';
// var user = $.cookie('user');
var now = new Date().getTime(); //时间戳
var pagesize = '20'; // 分页数量
// if (!islogin) {
//     var userInfo;
//     if ($.cookie('userInfo')) {
//         var userInfo = JSON.parse($.cookie('userInfo'));
//     } else {
//         window.location.replace('login.html');
//     };
// }
function add0(m) { return m < 10 ? '0' + m : m };
function GetRequest() {
    var url = location.search; //获取url中"?"符后的字串  
    var theRequest = new Object();
    if (url.indexOf("?") != -1) {
        var str = url.substr(1);
        strs = str.split("&");
        for (var i = 0; i < strs.length; i++) {
            theRequest[strs[i].split("=")[0]] = unescape(strs[i].split("=")[1]);
        }
    }
    return theRequest;
}

function getUserInfo() { //获取个人信息
    if ($.cookie('userInfo')) {
        return JSON.parse($.cookie('userInfo'));
    }
}

function hideMark() { //隐藏遮罩
    $(".markBox").hide()
}

function winload() { //页面加载成功
    $(window).load(function() {
        vm.isloadsuccess = true;
    })
}