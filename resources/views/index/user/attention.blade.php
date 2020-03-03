@extends('index.public.index')

@section('title')
    <title>关注的人</title>
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
            <li class="layui-nav-item layui-this">
                <a href="{{url('user/attention')}}">
                    <i class="layui-icon">&#xe611;</i>
                    关注的人
                </a>
            </li>

            <li class="layui-nav-item">
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
            {{--<div class="fly-msg" style="margin-top: 15px;">--}}
            {{--您的邮箱尚未验证，这比较影响您的帐号安全，<a href="activate.html">立即去激活？</a>--}}
            {{--</div>--}}
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                {{--<ul class="layui-tab-title" id="LAY_mine">--}}
                {{--<li data-type="mine-jie" lay-id="index" class="layui-this">我发的帖（<span>89</span>）</li>--}}
                {{--<li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖（<span>16</span>）--}}
                {{--</li>--}}
                {{--</ul>--}}
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-tab-item layui-show">
                        <ul class="fly-list">
                            @foreach($users as $user)
                                <li>
                                    <a href="{{url('user/home/'.$user->attention_id)}}" class="fly-avatar">
                                        <img src="{{url($user->img_url)}}"
                                             alt="贤心">
                                    </a>
                                    <h2>
                                        <a href="{{url('user/home/'.$user->attention_id)}}">{{$user->username}}</a>
                                    </h2>
                                    <div class="fly-list-info">
                                        <a href="" link>
                                            <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                                            <i class="layui-badge fly-badge-vip">VIP3</i>
                                        </a>
                                        <span>加入时间：{{$user->created_at}}</span>

                                        <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i
                                                    class="iconfont icon-kiss"></i> 60</span>

                                    </div>

                                </li>
                            @endforeach
                            {{----}}
                        </ul>
                        <div id="LAY_page1"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

    </script>
@endsection