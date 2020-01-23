@extends('index.public.index')

@section('title')
    <title>用户中心</title>
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
            <li class="layui-nav-item layui-this">
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
                        <form class="layui-form" method="post" action="" style="margin-bottom: 10px">
                            <div class="layui-input-inline">
                                <input type="text" name="collection_title" placeholder="请输入标题"
                                       autocomplete="off" class="layui-input" value="{{Session::get('collection_title')}}">
                            </div>

                            <div class="layui-input-inline">
                                <input type="month" name="collection_month"
                                       autocomplete="off" class="layui-input" value="{{Session::get('collection_month')}}">
                            </div>

                            <div class="layui-input-inline">
                                <select name="collection_category">
                                    <option value="">全部</option>
                                    @foreach($categorys as $category)
                                        @if($category->id == Session::get('collection_category'))
                                            <option value="{{$category->id}}" selected>{{$category->classname}}</option>
                                        @else
                                            <option value="{{$category->id}}">{{$category->classname}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>

                            @csrf

                            <div class="layui-input-inline">
                                <button class="layui-btn" lay-submit lay-filter="formDemo">查询</button>
                            </div>

                        </form>
                        <ul class="mine-view jie-row" id="collection">
                            {{--<li>--}}
                                {{--<a class="jie-title" href="../jie/detail.html" target="_blank">基于 layui 的极简社区页面模版</a>--}}
                                {{--<i>收藏于23小时前</i>--}}
                            {{--</li>--}}
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
        layui.use('flow', function () {
            var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
            var flow = layui.flow;
            flow.load({
                elem: '#article' //指定列表容器
                , done: function (page, next) { //到达临界点（默认滚动触发），触发下一页
                    var lis = [];
                    //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
                    $.get('{{url('user/indexToMy')}}?page=' + page, function (res) {
                        //假设你的列表返回在data集合中
                        res = $.parseJSON(res)
                        layui.each(res.data, function (index, item) {
                            lis.push('<li>' + '<a class="mine-show">' + item.classname + '</a>\n' +
                                '                                    <a class="jie-title" href=""\n' +
                                '                                       target="_blank">' + item.title + '</a>\n' +
                                '                                    <i>' + item.create_time + '</i>\n' +
                                '                                    <a class="mine-edit" href="/article/edit/' + item.article_id + '">编辑</a>\n' +
                                '                                    <em>' + item.read + '阅/' + item.comment_count + '答</em>' + '</li>');
                        });

                        //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
                        //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
                        next(lis.join(''), page < res.last_page);
                    });
                }
            });
        });

        layui.use('flow', function () {
            var $ = layui.jquery; //不用额外加载jQuery，flow模块本身是有依赖jQuery的，直接用即可。
            var flow = layui.flow;
            flow.load({
                elem: '#collection' //指定列表容器
                , done: function (page, next) { //到达临界点（默认滚动触发），触发下一页
                    var lis = [];
                    //以jQuery的Ajax请求为例，请求下一页数据（注意：page是从2开始返回）
                    $.get('{{url('user/indexToCollection')}}?page=' + page, function (res) {
                        //假设你的列表返回在data集合中
                        res = $.parseJSON(res)
                        layui.each(res.data, function (index, item) {
                            lis.push('<li>\n' +
                                '                                <a class="jie-title" href="/article/detail/'+item.article_id+'" target="_blank">'+item.title+'</a>\n' +
                                '                                <i>收藏于'+item.collection_time+'</i>\n' +
                                '                            </li>');
                        });

                        //执行下一页渲染，第二参数为：满足“加载更多”的条件，即后面仍有分页
                        //pages为Ajax返回的总页数，只有当前页小于总页数的情况下，才会继续出现加载更多
                        next(lis.join(''), page < res.last_page);
                    });
                }
            });
        });
    </script>
@endsection