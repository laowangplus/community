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
                <div class="fly-panel" style="margin-bottom: 0;">

                    <div class="fly-panel-title fly-filter">
                        <a href="" class="layui-this">综合</a>
                        <span class="fly-mid"></span>
                        {{--<a href="">未结</a>--}}
                        {{--<span class="fly-mid"></span>--}}
                        {{--<a href="">已结</a>--}}
                        {{--<span class="fly-mid"></span>--}}
                        <a href="">精华</a>
                        <span class="fly-filter-right layui-hide-xs">
            <a href="" class="layui-this">按最新</a>
            <span class="fly-mid"></span>
            <a href="">按热议</a>
          </span>
                    </div>

                    <ul class="fly-list">
                        @foreach($articles as $article)
                            <li>
                                <a href="{{url('user/home/'.$article->user_id)}}" class="fly-avatar">
                                    <img src="{{url($article->img_url)}}"
                                         alt="{{$article->username}}">
                                </a>
                                <h2>
                                    <a href="{{url('article/detail/'.$article->article_id)}}">{{ $article->title }}</a>
                                </h2>
                                <div class="fly-list-info">
                                    <a href="{{url('user/home/'.$article->user_id)}}" link>
                                        <cite>{{ $article->username }}</cite>
                                        <!--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>-->
                                        {{--<i class="layui-badge fly-badge-vip">VIP3</i>--}}
                                    </a>
                                    <span>{{$article->create_time}}</span>

                                    <span class="fly-list-kiss layui-hide-xs" title="悬赏飞吻"><i
                                                class="iconfont icon-kiss"></i> {{$article->experience}}</span>
                                    @if($article->accept == 1)
                                        <span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>
                                    @endif
                                    <span class="fly-list-nums">
                <i class="iconfont icon-pinglun1" title="回答"></i> {{ $article->comment_count }}
              </span>
                                </div>
                                <div class="fly-list-badge">
                                    @if($article->top == 1)
                                        <span class="layui-badge layui-bg-black">置顶</span>
                                    @endif
                                    @if($article->essence == 1)
                                        <span class="layui-badge layui-bg-red">精帖</span>
                                    @endif
                                </div>
                            </li>
                    @endforeach

                    <!-- <div class="fly-none">没有相关数据</div> -->
                    {{--分页模块--}}
                        <div style="text-align: center">
                            <div class="laypage-main">
                                {{--@if($articles->total() <=0 )--}}
                                {{--@elseif($articles->total() > 1 && $articles->total() < 5)--}}
                                    {{--@if($articles->currentPage() > 1)--}}
                                        {{--<a href="{{url('?pager=1')}}" class="laypage-last" title="首页">首页</a>--}}
                                    {{--@endif--}}
                                    {{--<a href="{{$articles->previousPageUrl()}}" class="laypage-prev">上一页</a>--}}
                                    {{--@for($i=1; $i<=$articles->total()+1; $i++)--}}
                                        {{--@if($i == $articles->currentPage())--}}
                                            {{--<span class="laypage-curr">{{$i}}</span>--}}
                                        {{--@else--}}
                                            {{--<a href="?page={{$i}}">{{$i}}</a>--}}
                                        {{--@endif--}}
                                    {{--@endfor--}}
                                    {{--<a href="{{$articles->nextPageUrl()}}" class="laypage-next">下一页</a>--}}
                                    {{--<a href="{{ url('?pager='.$articles->total()) }}" class="laypage-last" title="尾页">尾页</a>--}}
                                {{--@else--}}
                                    {{--@if($articles->currentPage() > 1)--}}
                                        {{--<a href="{{url('?pager=1')}}" class="laypage-last" title="首页">首页</a>--}}
                                    {{--@endif--}}
                                    {{--<a href="{{$articles->previousPageUrl()}}" class="laypage-prev">上一页</a>--}}
                                    {{--@if($articles->currentPage() >= 5)--}}
                                        {{--<span>…</span>--}}
                                    {{--@endif--}}
                                    {{--@if($articles->currentPage() < 5)--}}
                                        {{--@for($i=1; $i<=5; $i++)--}}
                                            {{--@if($i == $articles->currentPage())--}}
                                                {{--<span class="laypage-curr">{{$i}}</span>--}}
                                            {{--@else--}}
                                                {{--<a href="?page={{$i}}">{{$i}}</a>--}}
                                            {{--@endif--}}
                                        {{--@endfor--}}
                                    {{--@elseif($articles->currentPage() >= 5 && $articles->currentPage() <= $articles->total()-4)--}}
                                        {{--@for($i=$articles->currentPage()-2; $i<=$articles->currentPage()+2; $i++)--}}
                                            {{--@if($i == $articles->currentPage())--}}
                                                {{--<span class="laypage-curr">{{$i}}</span>--}}
                                            {{--@else--}}
                                                {{--<a href="?page={{$i}}">{{$i}}</a>--}}
                                            {{--@endif--}}
                                        {{--@endfor--}}
                                    {{--@else--}}
                                        {{--@for($i=$articles->total()-4; $i<=$articles->total(); $i++)--}}
                                            {{--@if($i == $articles->currentPage())--}}
                                                {{--<span class="laypage-curr">{{$i}}</span>--}}
                                            {{--@else--}}
                                                {{--<a href="?page={{$i}}">{{$i}}</a>--}}
                                            {{--@endif--}}
                                        {{--@endfor--}}
                                    {{--@endif--}}

                                    {{--@if($articles->currentPage() <= $articles->total()-4)--}}
                                        {{--<span>…</span>--}}
                                    {{--@endif--}}
                                    {{--<a href="{{$articles->nextPageUrl()}}" class="laypage-next">下一页</a>--}}
                                    {{--<a href="{{ url('?pager='.$articles->total()) }}" class="laypage-last" title="尾页">尾页</a>--}}
                                {{--@endif--}}

                                {{--<span class="laypage-curr">1</span>--}}
                                {{--<a href="/jie/page/2/">2</a>--}}
                                {{--<a href="/jie/page/3/">3</a>--}}
                                {{--<a href="/jie/page/4/">4</a>--}}
                                {{--<a href="/jie/page/5/">5</a>--}}
                                {{--<span>…</span>--}}
                                {{--<a href="/jie/page/148/" class="laypage-last" title="尾页">尾页</a>--}}
                                {{--<a href="/jie/page/2/" class="laypage-next">下一页</a>--}}

                                {{$articles->links('vendor.pagination.default')}}

                            </div>
                        </div>
                    </ul>
                </div>
            </div>
            <div class="layui-col-md4">
                <dl class="fly-panel fly-list-one">
                    <dt class="fly-panel-title">本周热议</dt>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>
                    <dd>
                        <a href="">基于 layui 的极简社区页面模版</a>
                        <span><i class="iconfont icon-pinglun1"></i> 16</span>
                    </dd>

                    <!-- 无数据时 -->
                    <!--
                    <div class="fly-none">没有相关数据</div>
                    -->
                </dl>

                <div class="fly-panel">
                    <div class="fly-panel-title">
                        这里可作为广告区域
                    </div>
                    <div class="fly-panel-main">
                        <a href="" target="_blank" class="fly-zanzhu" style="background-color: #393D49;">虚席以待</a>
                    </div>
                </div>

                <div class="fly-panel fly-link">
                    <h3 class="fly-panel-title">友情链接</h3>
                    <dl class="fly-panel-main">
                        <dd><a href="http://www.layui.com/" target="_blank">layui</a>
                        <dd>
                        <dd><a href="http://layim.layui.com/" target="_blank">WebIM</a>
                        <dd>
                        <dd><a href="http://layer.layui.com/" target="_blank">layer</a>
                        <dd>
                        <dd><a href="http://www.layui.com/laydate/" target="_blank">layDate</a>
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