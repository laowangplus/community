@extends('index.public.index')

@section('title')
    <title>个人设置</title>
@endsection

@section('contain')
    <div class="layui-container fly-marginTop fly-user-main">
        <ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
            <li class="layui-nav-item">
                <a href="{{url('user/home')}}">
                    <i class="layui-icon">&#xe609;</i>
                    我的主页
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="{{url('user/attention')}}">
                    <i class="layui-icon">&#xe611;</i>
                    关注的人
                </a>
            </li>

            <li class="layui-nav-item layui-this">
                <a href="{{url('user/message')}}">
                    <i class="layui-icon">&#xe611;</i>
                    我的消息
                    <span class="layui-badge">
                        {{\Illuminate\Support\Facades\Redis::scard('user_message:'.Session::get('id'))}}
                    </span>
                </a>
            </li>

            <li class="layui-nav-item">
                <a href="{{url('user/article')}}">
                    <i class="layui-icon">&#xe612;</i>
                    我的发帖
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="{{url('user/collection')}}">
                    <i class="layui-icon">&#xe612;</i>
                    我的收藏
                </a>
            </li>
            <li class="layui-nav-item">
                <a href="{{url('user/set')}}">
                    <i class="layui-icon">&#xe620;</i>
                    基本设置
                </a>
            </li>
        </ul>
        <div class="site-tree-mobile layui-hide">
            <i class="layui-icon">&#xe602;</i>
        </div>
        <div class="site-mobile-shade"></div>

        <div class="site-tree-mobile layui-hide">
            <i class="layui-icon">&#xe602;</i>
        </div>
        <div class="site-mobile-shade"></div>


        <div class="fly-panel fly-panel-user" pad20>
            <div class="layui-tab layui-tab-brief" lay-filter="user" id="LAY_msg" style="margin-top: 15px;">
                <button class="layui-btn layui-btn-danger" id="LAY_delallmsg" onclick="clearMessage()">清空全部消息</button>
                <div id="LAY_minemsg" style="margin-top: 10px;">
                    @if(!$messages)
                    <div class="fly-none">您暂时没有最新消息</div>
                    @endif
                    <ul class="mine-msg">
                        @foreach($messages as $message)
                        <li data-id="123">
                            <blockquote class="layui-elem-quote">
                                {!! $message->message !!}
                            </blockquote>
                            <p>
                                <span>{{$message->created_at}}</span>
                                <a href="javascript:;" class="layui-btn layui-btn-small layui-btn-danger fly-delete" onclick="deleteMessage(this, {{$message->id}})">删除</a>
                            </p>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection

@section('script')
    <script>
        function deleteMessage(obj, message_id) {
            var $ = layui.jquery;
            $.get('{{url('user/deleteMessage')}}/'+message_id, function (res) {
                res = $.parseJSON(res);
                if (res.code == 1){
                    $(obj).parent('p').parent('li').remove();
                }
            })
        }

        function clearMessage() {
            var $ = layui.jquery;
            $.get('{{url('user/clearMessage')}}', function (res) {
                res = $.parseJSON(res);
                if (res.code == 1){
                    $('#LAY_minemsg').html('<div class="fly-none">您暂时没有最新消息</div>')
                }
            })
        }
    </script>
@endsection
