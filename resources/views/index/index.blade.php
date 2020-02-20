@extends('index.public.index')

@section('title')
    <title>首页</title>
@endsection

@section('contain')
    <div class="fly-panel fly-column">
        <div class="layui-container">
            <ul class="layui-clear">
                <li class="layui-hide-xs layui-this"><a href="/">首页</a></li>
                <li><a href="{{url('article/category/4')}}">提问</a></li>
                <li><a href="{{url('article/category/2')}}">分享<span class="layui-badge-dot"></span></a></li>
                <li><a href="{{url('article/category/3')}}">讨论</a></li>
                <li><a href="{{url('article/category/1')}}">博文</a></li>
                <li><a href="{{url('article/category/6')}}">公告</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li>

                <!-- 用户登入后显示 -->
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="{{url('user/article')}}">我发表的贴</a></li>
                <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="{{url('user/collection')}}">我收藏的贴</a>
                </li>
            </ul>

            <div class="fly-column-right layui-hide-xs">
                <span class="fly-search"><i class="layui-icon"></i></span>
                <a href="{{ url('publish/add') }}" class="layui-btn">发表新帖</a>
            </div>
            <div class="layui-hide-sm layui-show-xs-block"
                 style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
                <span class="fly-search"><i class="layui-icon"></i></span>
                <a href="{{ url('publish/add') }}" class="layui-btn">发表新帖</a>
            </div>
        </div>
    </div>

    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8">
                <div class="fly-panel">
                    <div class="fly-panel-title fly-filter">
                        <a>置顶</a>
                        <a href="#signin" class="layui-hide-sm layui-show-xs-block fly-right" id="LAY_goSignin"
                           style="color: #FF5722;">去签到</a>
                    </div>
                    <ul class="fly-list">
                        @foreach($articles as $article)
                            <li>
                                <a href="{{url('user/home/'.$article->user_id)}}" class="fly-avatar">
                                    <img src="{{$article->img_url}}"
                                         alt="{{$article->username}}">
                                </a>
                                <h2>
                                    <a class="layui-badge">{{$article->classname}}</a>
                                    <a href="{{url('article/detail/'.$article->article_id)}}">{{$article->title}}</a>
                                </h2>
                                <div class="fly-list-info">
                                    <a href="{{url('user/home/'.$article->user_id)}}" link>
                                        <cite>{{$article->username}}</cite>
                                        {{--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>--}}
                                        {{--<i class="layui-badge fly-badge-vip">VIP3</i>--}}
                                    </a>
                                    <span>{{$article->create_time}}</span>

                                    <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i
                                                class="iconfont icon-kiss"></i> {{$article->experience}}</span>
                                    @if($article->category_id == 4 && $article->accept == 1)
                                    <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>
                                    @endif
                                    <span class="fly-list-nums">
                <i class="iconfont icon-pinglun1" title="回答"></i> {{$article->comment_count}}
              </span>
                                </div>

                            </li>
                        @endforeach

                        {{----}}
                    </ul>
                </div>

                <div class="fly-panel" style="margin-bottom: 0;">

                    <div class="fly-panel-title fly-filter">
                        <a>猜你喜欢</a>
                        <a href="#signin" class="layui-hide-sm layui-show-xs-block fly-right" id="LAY_goSignin"
                           style="color: #FF5722;">去签到</a>
                        {{--<a href="" class="layui-this">综合</a>--}}
                        {{--<span class="fly-mid"></span>--}}
                        {{--<a href="">未结</a>--}}
                        {{--<span class="fly-mid"></span>--}}
                        {{--<a href="">已结</a>--}}
                        {{--<span class="fly-mid"></span>--}}
                        {{--<a href="">精华</a>--}}
                        {{--<span class="fly-filter-right layui-hide-xs">--}}
            {{--<a href="" class="layui-this">按最新</a>--}}
            {{--<span class="fly-mid"></span>--}}
            {{--<a href="">按热议</a>--}}
          </span>
                    </div>

                    <ul class="fly-list">
                        @foreach($like_articles as $like_article)
                        <li>
                            <a href="{{url('user/home/'.$like_article->user_id)}}" class="fly-avatar">
                                <img src="{{url($like_article->img_url)}}"
                                     alt="{{$like_article->username}}">
                            </a>
                            <h2>
                                <a class="layui-badge">{{$like_article->classname}}</a>
                                <a href="{{url('article/detail/'.$like_article->article_id)}}">{{$like_article->title}}</a>
                            </h2>
                            <div class="fly-list-info">
                                <a href="{{url('user/home/'.$article->user_id)}}" link>
                                    <cite>{{$like_article->username}}</cite>
                                    <!--
                                    <i class="iconfont icon-renzheng" title="认证信息：XXX"></i>
                                    <i class="layui-badge fly-badge-vip">VIP3</i>
                                    -->
                                </a>
                                <span>{{$like_article->create_time}}</span>

                                <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i
                                            class="iconfont icon-kiss"></i> {{$like_article->experience}}</span>
                                <!--<span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>-->
                                <span class="fly-list-nums">
                <i class="iconfont icon-pinglun1" title="回答"></i> {{$like_article->comment_count}}
              </span>
                            </div>
                            <div class="fly-list-badge">
                                <!--<span class="layui-badge layui-bg-red">精帖</span>-->
                            </div>
                        </li>
                            @endforeach
                    </ul>
                    {{--<div style="text-align: center">--}}
                        {{--<div class="laypage-main">--}}
                            {{--<a href="jie/index.html" class="laypage-next">更多求解</a>--}}
                        {{--</div>--}}
                    {{--</div>--}}

                </div>
            </div>
            <div class="layui-col-md4">

                <div class="fly-panel">
                    <h3 class="fly-panel-title">热门标签</h3>
                    <ul class="fly-panel-main fly-list-static">
                        @foreach($hot_tags as $hot_tag)
                        <li>
                            <a class="layui-btn layui-btn-sm layui-btn-normal layui-btn-radius" href="http://fly.layui.com/jie/4281/" >{{$hot_tag->tag_name}}</a>
                        </li>
                        @endforeach
                    </ul>
                </div>


                <div class="fly-panel fly-signin">
                    <div class="fly-panel-title">
                        签到
                        <i class="fly-mid"></i>
                        <a href="javascript:;" class="fly-link" id="LAY_signinHelp">说明</a>
                        <i class="fly-mid"></i>
                        <a href="javascript:;" class="fly-link" id="LAY_signinTop">活跃榜<span
                                    class="layui-badge-dot"></span></a>
                        @if(Session::exists('id'))
                            <span class="fly-signin-days">已连续签到<cite>{{$sign->days}}</cite>天</span>
                        @endif
                    </div>
                    <div class="fly-panel-main fly-signin-main">
                        @if(Session::exists('id'))
                            @if(Session::get('sign_status') == 0)
                            <button class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</button>
                            <span>可获得<cite>{{$sign->experience}}</cite>飞吻</span>
                            @else
                            <!-- 已签到状态 -->
                            <button class="layui-btn layui-btn-disabled">今日已签到</button>
                            <span>获得了<cite>{{$sign->experience}}</cite>飞吻</span>
                            @endif
                        @else
                            <a href="/login" class="layui-btn layui-btn-danger" id="LAY_signin">今日签到</a>
                        @endif
                    </div>
                </div>

                <div class="fly-panel fly-rank fly-rank-reply" id="LAY_replyRank">
                    <h3 class="fly-panel-title">回贴周榜</h3>
                    <dl>
                        <!--<i class="layui-icon fly-loading">&#xe63d;</i>-->
                        <dd>
                            <a href="user/home.html">
                                <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg"><cite>贤心</cite><i>106次回答</i>
                            </a>
                        </dd>
                        <dd>
                            <a href="user/home.html">
                                <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg"><cite>贤心</cite><i>106次回答</i>
                            </a>
                        </dd>
                    </dl>
                </div>

                <dl class="fly-panel fly-list-one">
                    <dt class="fly-panel-title">本周热议</dt>
                    <dd>
                        <a href="jie/detail.html">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>

                    <!-- 无数据时 -->
                    <!--
                    <div class="fly-none">没有相关数据</div>
                    -->
                </dl>


                <div class="fly-panel fly-link">
                    <h3 class="fly-panel-title">友情链接</h3>
                    <dl class="fly-panel-main">
                        <dd><a href="http://www.layui.com/" >layui</a>
                        <dd>
                        <dd><a href="http://layim.layui.com/" >WebIM</a>
                        <dd>
                        <dd><a href="http://layer.layui.com/" >layer</a>
                        <dd>
                        <dd><a href="http://www.layui.com/laydate/" >layDate</a>
                        <dd>
                        <dd>
                            <a href="mailto:xianxin@layui-inc.com?subject=%E7%94%B3%E8%AF%B7Fly%E7%A4%BE%E5%8C%BA%E5%8F%8B%E9%93%BE"
                               class="fly-link">申请友链</a>
                        <dd>
                    </dl>
                </div>

            </div>
        </div>
    </div>
@endsection