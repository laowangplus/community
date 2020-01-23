<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    @yield('title')
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="keywords" content="fly,layui,前端社区">
    <meta name="description" content="Fly社区是模块化前端UI框架Layui的官网社区，致力于为web开发提供强劲动力">
    <link rel="stylesheet" href="{{@asset('/index/res/layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{@asset('/index/res/css/global.css')}}">
    @yield('css')
</head>
<body>

<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="/">
            <img src="../res/images/logo.png" alt="layui">
        </a>
        <ul class="layui-nav fly-nav layui-hide-xs">
            <li class="layui-nav-item layui-this">
                <a href="/"><i class="iconfont icon-jiaoliu"></i>交流</a>
            </li>
            <li class="layui-nav-item">
                <a href="case/case.html"><i class="iconfont icon-iconmingxinganli"></i>案例</a>
            </li>
            <li class="layui-nav-item">
                <a href="http://www.layui.com/" target="_blank"><i class="iconfont icon-ui"></i>框架</a>
            </li>
        </ul>

        <ul class="layui-nav fly-nav-user">

            <!-- 未登入的状态 -->
            @if (!Session::has('id'))

                <li class="layui-nav-item">
                    <a class="iconfont icon-touxiang layui-hide-xs" href="user/login.html"></a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{url('login')}}">登入</a>
                </li>
                <li class="layui-nav-item">
                    <a href="{{url('register')}}">注册</a>
                </li>
                <li class="layui-nav-item layui-hide-xs">
                    <a href="/app/qq/" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" title="QQ登入"
                       class="iconfont icon-qq"></a>
                </li>
                <li class="layui-nav-item layui-hide-xs">
                    <a href="/app/weibo/" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" title="微博登入"
                       class="iconfont icon-weibo"></a>
                </li>

                <!-- 登入后的状态 -->
            @else
                <li class="layui-nav-item">
                    <a class="fly-nav-avatar" href="javascript:;">
                        <cite class="layui-hide-xs">{{ Session::get('username') }}</cite>
                        <i class="iconfont icon-renzheng layui-hide-xs" title="认证信息：layui 作者"></i>
                        <i class="layui-badge fly-badge-vip layui-hide-xs">VIP3</i>
                        @if(Session::has('img_url'))
                            <img src="{{url(str_replace('public', 'storage', Session::get('img_url')))}}">
                        @else
                            <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg">
                        @endif
                    </a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{url('user/home')}}"><i class="layui-icon"
                                                              style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a>
                        </dd>
                        <dd>
                            <a href="{{url('user/message')}}"><i class="iconfont icon-tongzhi" style="top: 4px;"></i>我的消息
                                @if(\Illuminate\Support\Facades\Redis::scard('user_message:'.Session::get('id')) > 0)
                                <span class="layui-badge-dot"></span>
                                @endif
                            </a>
                        </dd>
                        <dd><a href="{{url('user/attention')}}"><i class="iconfont icon-jiaoliu" style="top: 4px;"></i>关注的人</a>
                        </dd>
                        <dd><a href="{{url('user/set')}}"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>

                        <hr style="margin: 5px 0;">
                        <dd><a href="{{url('/logout')}}" style="text-align: center;">退出</a></dd>
                    </dl>
                </li>
            @endif
        </ul>
    </div>
</div>

<div class="cxt_nav_wp">
    <ul class="cxt_nav layui-clear">
        <li class="layui-this"><a href="/Post/column/all/all">All</a></li>
        <li><a href="/Post/column/android">Android</a></li>
        <li><a href="/Post/column/ios">IOS</a></li>
        <li><a href="/Post/column/java">JAVA</a></li>
        <li><a href="/Post/column/php">PHP</a></li>
        <li><a href="/Post/column/web">WEB</a></li>
        <li><a href="/Post/column/h5Game">H5Game</a></li>
    </ul>
</div>

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

@yield('contain')

<div class="fly-footer">
    <p><a href="http://fly.layui.com/" target="_blank">Fly社区</a> 2017 &copy; <a href="http://www.layui.com/"
                                                                                target="_blank">layui.com 出品</a></p>
    <p>
        <a href="http://fly.layui.com/jie/3147/" target="_blank">付费计划</a>
        <a href="http://www.layui.com/template/fly/" target="_blank">获取Fly社区模版</a>
        <a href="http://fly.layui.com/jie/2461/" target="_blank">微信公众号</a>
    </p>
</div>


<script src="{{@asset('/index/res/layui/layui.js')}}"></script>
{{--<script src="{{@asset('\index\res\layui\lay\modules\jquery.js')}}"></script>--}}
<script>
    layui.cache.page = '';
    layui.cache.user = {
        username: '游客'
        , uid: -1
        , avatar: '../res/images/avatar/00.jpg'
        , experience: 83
        , sex: '男'
    };
    layui.config({
        version: "3.0.0"
        , base: "{{@asset('/index/res/mods/')}}/" //这里实际使用时，建议改成绝对路径
    }).extend({
        fly: 'index'
    }).use('fly');
</script>
@yield('script')

<script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");
    document.write(unescape("%3Cspan id='cnzz_stat_icon_30088308'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "w.cnzz.com/c.php%3Fid%3D30088308' type='text/javascript'%3E%3C/script%3E"));</script>

</body>
</html>