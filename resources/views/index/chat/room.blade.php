<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('/index/chat/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/index/chat/rolling/css/rolling.css')}}">
    <link rel="stylesheet" href="{{asset('/index/chat/stylesheets/style.css')}}">
    <script type="text/javascript" src="{{asset('/index/chat/javascripts/jquery-1.11.2.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/index/chat/bootstrap/js/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/index/chat/rolling/js/rolling.js')}}"></script>
</head>
<body class="room">
<div class="scrollbar-macosx">
    <div class="header">
        <div class="toptext">
            <a href="index.html">
                <span class="glyphicon glyphicon-arrow-left"></span> 返回大厅
            </a>
        </div>
        <ul class="topnavlist">
            <li class="userlist">
                <a><span class="glyphicon glyphicon-th-list"></span>用户列表</a>
                <div class="popover fade bottom in">
                    <div class="arrow"></div>
                    <h3 class="popover-title">在线用户{{count($live_users)}}人</h3>
                    <div class="popover-content scrollbar-macosx">
                        <ul>
                            @foreach($live_users as $live_user)
                            <li>
                                <img src="{{$live_user['img_url']}}" alt="{{$live_user['username']}}">
                                <b>{{$live_user['username']}}</b>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
        <div class="clapboard hidden"></div>
    </div>
    <div class="main container">
        <div class="col-md-12">
            <ul class="chat_info">
                {{--<li class="systeminfo">--}}
                    {{--<span>【绿巨人】加入了房间</span>--}}
                {{--</li>--}}
                {{--<li class="left">--}}
                    {{--<img src="images/user/12.png" alt="">--}}
                    {{--<b>美国队长</b>--}}
                    {{--<i>09:15</i>--}}
                    {{--<div>嗨起来！！！</div>--}}
                {{--</li>--}}
            </ul>
        </div>
    </div>
    <div class="input">
        <div class="center">
            <div class="tools">

                <span class="glyphicon glyphicon-heart face_btn"></span>
                <span class="glyphicon glyphicon-picture imgFileico"></span>

                <input type="file" class="imgFileBtn hidden" accept="image/*">
                <div class="faces popover fade top in">
                    <div class="arrow"></div>
                    <h3 class="popover-title">表情包</h3>
                    <div class="popover-content scrollbar-macosx">
                        <img src="/index/chat/images/face/1.gif" alt="1">
                        <img src="/index/chat/images/face/2.gif" alt="2">
                        <img src="/index/chat/images/face/3.gif" alt="3">
                        <img src="/index/chat/images/face/4.gif" alt="4">
                        <img src="/index/chat/images/face/5.gif" alt="5">
                        <img src="/index/chat/images/face/6.gif" alt="6">
                        <img src="/index/chat/images/face/7.gif" alt="7">
                        <img src="/index/chat/images/face/8.gif" alt="8">
                        <img src="/index/chat/images/face/9.gif" alt="9">
                        <img src="/index/chat/images/face/10.gif" alt="10">
                        <img src="/index/chat/images/face/11.gif" alt="11">
                        <img src="/index/chat/images/face/12.gif" alt="">
                        <img src="/index/chat/images/face/13.gif" alt="">
                        <img src="/index/chat/images/face/14.gif" alt="">
                        <img src="/index/chat/images/face/15.gif" alt="">
                        <img src="/index/chat/images/face/16.gif" alt="">
                        <img src="/index/chat/images/face/17.gif" alt="">
                        <img src="/index/chat/images/face/18.gif" alt="">
                        <img src="/index/chat/images/face/19.gif" alt="">
                        <img src="/index/chat/images/face/20.gif" alt="">
                        <img src="/index/chat/images/face/21.gif" alt="">
                        <img src="/index/chat/images/face/22.gif" alt="">
                        <img src="/index/chat/images/face/23.gif" alt="">
                        <img src="/index/chat/images/face/24.gif" alt="">
                        <img src="/index/chat/images/face/25.gif" alt="">
                        <img src="/index/chat/images/face/26.gif" alt="">
                        <img src="/index/chat/images/face/27.gif" alt="">
                        <img src="/index/chat/images/face/28.gif" alt="">
                        <img src="/index/chat/images/face/29.gif" alt="">
                        <img src="/index/chat/images/face/30.gif" alt="">
                        <img src="/index/chat/images/face/31.gif" alt="">
                        <img src="/index/chat/images/face/32.gif" alt="">
                        <img src="/index/chat/images/face/33.gif" alt="">
                        <img src="/index/chat/images/face/34.gif" alt="">
                        <img src="/index/chat/images/face/35.gif" alt="">
                        <img src="/index/chat/images/face/36.gif" alt="">
                        <img src="/index/chat/images/face/37.gif" alt="">
                        <img src="/index/chat/images/face/38.gif" alt="">
                        <img src="/index/chat/images/face/39.gif" alt="">
                        <img src="/index/chat/images/face/40.gif" alt="">
                        <img src="/index/chat/images/face/41.gif" alt="">
                        <img src="/index/chat/images/face/42.gif" alt="">
                        <img src="/index/chat/images/face/43.gif" alt="">
                        <img src="/index/chat/images/face/44.gif" alt="">
                        <img src="/index/chat/images/face/45.gif" alt="">
                        <img src="/index/chat/images/face/46.gif" alt="">
                        <img src="/index/chat/images/face/47.gif" alt="">
                        <img src="/index/chat/images/face/48.gif" alt="">
                        <img src="/index/chat/images/face/49.gif" alt="">
                        <img src="/index/chat/images/face/50.gif" alt="">
                        <img src="/index/chat/images/face/51.gif" alt="">
                        <img src="/index/chat/images/face/52.gif" alt="">
                        <img src="/index/chat/images/face/53.gif" alt="">
                        <img src="/index/chat/images/face/54.gif" alt="">
                        <img src="/index/chat/images/face/55.gif" alt="">
                        <img src="/index/chat/images/face/56.gif" alt="">
                        <img src="/index/chat/images/face/57.gif" alt="">
                        <img src="/index/chat/images/face/58.gif" alt="">
                        <img src="/index/chat/images/face/59.gif" alt="">
                        <img src="/index/chat/images/face/60.gif" alt="">
                        <img src="/index/chat/images/face/61.gif" alt="">
                        <img src="/index/chat/images/face/62.gif" alt="">
                        <img src="/index/chat/images/face/63.gif" alt="">
                        <img src="/index/chat/images/face/64.gif" alt="">
                        <img src="/index/chat/images/face/65.gif" alt="">
                        <img src="/index/chat/images/face/66.gif" alt="">
                        <img src="/index/chat/images/face/67.gif" alt="">
                        <img src="/index/chat/images/face/68.gif" alt="">
                        <img src="/index/chat/images/face/69.gif" alt="">
                        <img src="/index/chat/images/face/70.gif" alt="">
                        <img src="/index/chat/images/face/71.gif" alt="">
                        <img src="/index/chat/images/face/72.gif" alt="">
                        <img src="/index/chat/images/face/73.gif" alt="">
                        <img src="/index/chat/images/face/75.gif" alt="">
                    </div>
                </div>
            </div>
            <div class="text">
                <div class="col-xs-10 col-sm-11">
                    <input type="text" class="form-control" placeholder="输入聊天信息...">
                </div>
                <div class="col-xs-2 col-sm-1">
                    <a id="subxx" role="button"><span class="glyphicon glyphicon-share-alt"></span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('/index/chat/javascripts/Public.js')}}"></script>
<script>
    //发送信息
    function sends_message (userName, userPortrait, message) {
        var date = new Date();
        var Hours = date.getHours();
        var minutes = date.getMinutes() + 1;
        var seconds = date.getSeconds();
        if (Hours < 10) {
            Hours = "0" + Hours;
        }
        if (minutes < 10) {
            minutes = "0" + minutes;
        }
        if (seconds < 10) {
            seconds = "0" + seconds;
        }
        var now = Hours + ":" + minutes + ":" + seconds;
        if(message!='') {
            $('.main .chat_info').html($('.main .chat_info').html() + '<li class="right"><img src="' + userPortrait + '" alt=""><b>' + userName + '</b><i>'+now+'</i><div class="aaa">' + message  +'</div></li>');
        }
    }

    //接受信息
    function receive_message (userName, userPortrait, message, time) {
        message = message.replace(/\</g,'&lt;');
        message = message.replace(/\>/g,'&gt;');
        message = message.replace(/\n/g,'<br/>');
        message = message.replace(/\[em_([0-9]*)\]/g,'<img src="{{asset('index/chat/images/face/$1.gif')}}" alt="" />');
        if(message!='') {
            $('.main .chat_info').html($('.main .chat_info').html() + '<li class="left"><img src="' + userPortrait + '" alt=""><b>' + userName + '</b><i>'+time+'</i><div>' + message  +'</div></li>');
        }
    }





    // --------------------聊天室内页面----------------------------------------------------

    // 发送图片

    $('.imgFileBtn').change(function(event) {


        var str = '<img src="images/chatimg/' + '1/201503/agafsdfeaef.jpg' +'" />'

        //处理发送信息
        let data = new Object();
        data.token = "{{$token}}";
        data.str = str;
        let data_json = JSON.stringify(data);
        console.log(data_json);
        ws.send(data_json);

        sends_message('{{$user_info['username']}}', '{{$user_info['img_url']}}', str); // sends_message(昵称,头像img_url,聊天内容);


        // 滚动条滚到最下面
        $('.scrollbar-macosx.scroll-content.scroll-scrolly_visible').animate({
            scrollTop: $('.scrollbar-macosx.scroll-content.scroll-scrolly_visible').prop('scrollHeight')
        }, 500);
    });

    // 发送消息

    $('.text input').focus();
    $('#subxx').click(function(event) {
        var str = $('.text input').val(); // 获取聊天内容

        //处理发送信息
        let data = new Object();
        data.token = "{{$token}}";
        data.str = str;
        let data_json = JSON.stringify(data);
        console.log(data_json);
        ws.send(data_json);


        str = str.replace(/\</g,'&lt;');
        str = str.replace(/\>/g,'&gt;');
        str = str.replace(/\n/g,'<br/>');
        if(str!='') {

            sends_message('{{$user_info['username']}}', '{{$user_info['img_url']}}', str); // sends_message(昵称,头像img_url,聊天内容);


            // 滚动条滚到最下面
            $('.scrollbar-macosx.scroll-content.scroll-scrolly_visible').animate({
                scrollTop: $('.scrollbar-macosx.scroll-content.scroll-scrolly_visible').prop('scrollHeight')
            }, 500);

        }

        $('.text input').val(''); // 清空输入框
        $('.text input').focus(); // 输入框获取焦点
    });


    //websocket连接
    var ws = new WebSocket("ws://47.102.205.111:9503/{{$token}}");
    ws.onopen = function(evt) {
        console.log(evt);
    };
    ws.onmessage = function(evt) {
        let data = JSON.parse(evt.data);
        console.log("Received Message: " + evt.data);
        if (data.flag == 0) {
            $('.chat_info').append("<li class=\"systeminfo\">\n" +
                "                    <span>【"+data.username+"】加入了房间</span>\n" +
                "                </li>");

        }
        else if (data.flag == 1) {
            receive_message(data.username, data.img_url, data.msg, data.time); // sends_message(昵称,头像id,聊天内容);

            // 滚动条滚到最下面
            $('.scrollbar-macosx.scroll-content.scroll-scrolly_visible').animate({
                scrollTop: $('.scrollbar-macosx.scroll-content.scroll-scrolly_visible').prop('scrollHeight')
            }, 500);
        }
        else if (data.flag == 2) {
            $('.chat_info').append("<li class=\"systeminfo\">\n" +
                "                    <span>【"+data.username+"】退出了房间</span>\n" +
                "                </li>");
        }
    };

</script>
</body>
</html>