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