@extends('index.public.index')

@section('title')
    <title>用户中心</title>
@endsection

@section('contain')
    <div class="fly-home fly-panel"
         style="background-image: url('{{asset($info->img_url)}}');  background-size: 100% 400px;">
        <img src="{{asset($info->img_url)}}" alt="贤心">
        {{--<i class="iconfont icon-renzheng" title="Fly社区认证"></i>--}}
        <h1>
            {{$info->username}}
            @if ($info->sex == 1)
                <i class="iconfont icon-nan"></i>
            @elseif($info->sex == 0)
                <i class="iconfont icon-nv"></i>
        @endif
        {{--<i class="layui-badge fly-badge-vip">VIP3</i>--}}
        <!--
            <span style="color:#c00;">（管理员）</span>
            <span style="color:#5FB878;">（社区之光）</span>
            <span>（该号已被封）</span>
            -->
        </h1>

        {{--<p style="padding: 10px 0; color: #5FB878;">认证信息：layui 作者</p>--}}

        <p class="fly-home-info">
            <i class="iconfont icon-kiss" title="飞吻"></i><span style="color: #FF7200;">66666 飞吻</span>
            <i class="iconfont icon-shijian"></i><span>{{$info->create_time}} 加入</span>
            <i class="iconfont icon-chengshi"></i><span>{{$info->city}}</span>
        </p>

        <p class="fly-home-sign">（{{$info->sign}}）</p>

        @if(Session::get('id') != $info->id)
            <div class="fly-sns" data-user="">
                <a id="attention" href="javascript:;" class="layui-btn layui-btn-primary fly-imActive"
                   data-type="addFriend"
                   onclick="attention(this, {{$info->id}})">关注</a>
                <a href="javascript:;" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">发送私信</a>
            </div>
        @endif

    </div>

    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md6 fly-home-jie">
                <div class="fly-panel">
                    <h3 class="fly-panel-title">{{$info->username}} 最近的帖子</h3>
                    <ul class="jie-row">
                        @foreach($articles as $article)
                            <li>
                                @if($article->top == 1)
                                    <span class="fly-stick">顶</span>
                                @endif
                                @if($article->essence == 1)
                                    <span class="fly-jing">精</span>
                                @endif
                                <a href="{{url('article/detail/'.$article->article_id)}}" class="jie-title"> {{$article->title}}</a>
                                <i>{{$article->created_at}}</i>
                                <em class="layui-hide-xs">{{$article->read}}阅/{{$article->comment_count}}答</em>
                            </li>
                    @endforeach
                    <!-- <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表任何帖子</i></div> -->
                    </ul>
                </div>
            </div>

            <div class="layui-col-md6 fly-home-da">
                <div class="fly-panel">
                    <h3 class="fly-panel-title">{{$info->username}} 最近的回答</h3>
                    <ul class="home-jieda">
                        @foreach($comments as $comment)
                        <li>
                            <p>
                                <span>{{$comment->created_at}}</span>
                                在<a href="" target="_blank">{{$comment->title}}</a>中回答：
                            </p>
                            <div class="home-dacontent">
                                {!! $comment->content !!}
                            </div>
                        </li>
                        @endforeach

                        <!-- <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><span>没有回答任何问题</span></div> -->
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        function attention(obj, id) {
            var $ = layui.jquery;
            text = $(obj).text()
            layer.alert('是否' + text + '?', function (index) {
                $.get('{{url('user/attention')}}/' + id, function (res) {
                    res = $.parseJSON(res)
                    if (res.code == 1) {
                        if (res.status == 0) {
                            $(obj).text('关注')
                        } else {
                            $(obj).text('取关')
                        }
                    }
                });

                layer.close(index);
            });

        }
    </script>
@endsection
