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
                        @for($i=1; $i<=75; $i++)
                            <img src="/index/chat/images/face/{{$i}}.gif" alt="{{$i}}">
                        @endfor
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
        message = message.replace(/\</g,'&lt;');
        message = message.replace(/\>/g,'&gt;');
        message = message.replace(/\n/g,'<br/>');
        message = message.replace(/\[em_([0-9]*)\]/g,'<img src="{{asset('index/chat/images/face/$1.gif')}}" alt="" />');
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