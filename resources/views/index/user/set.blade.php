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
            <li class="layui-nav-item layui-this">
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
            <div class="layui-tab layui-tab-brief" lay-filter="user">
                <ul class="layui-tab-title" id="LAY_mine">
                    <li class="layui-this" lay-id="info">我的资料</li>
                    <li lay-id="avatar">头像</li>
                    <li lay-id="pass">密码</li>
                    <li lay-id="bind">帐号绑定</li>
                </ul>
                <div class="layui-tab-content" style="padding: 20px 0;">
                    <div class="layui-form layui-form-pane layui-tab-item layui-show">
                        <form action="{{url('user/basic')}}" method="post">
                            <div class="layui-form-item">
                                <label for="L_email" class="layui-form-label">邮箱</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_email" name="email" required lay-verify="email"
                                           autocomplete="off" value="415813765@qq.com" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需<a href="activate.html"
                                                                                                   style="font-size: 12px; color: #4f99cf;">重新验证邮箱</a>。
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_username" class="layui-form-label">昵称</label>
                                <div class="layui-input-inline">
                                    <input type="text" id="L_username" name="username" required lay-verify="required"
                                           autocomplete="off" value="laowangplus" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_sex" class="layui-form-label">性别</label>
                                <div class="layui-input-inline">
                                    <select name="sex">
                                        <option value="2">保密</option>
                                        <option value="1">男</option>
                                        <option value="0">女</option>
                                    </select>
                                </div>
                            </div>
                            <div class="layui-form-item">
                                {{--<label for="L_city" class="layui-form-label">城市</label>--}}
                                {{--<div class="layui-input-inline">--}}
                                {{--<input type="text" id="L_city" name="city" autocomplete="off" value=""--}}
                                {{--class="layui-input">--}}
                                {{--</div>--}}
                                <div class="layui-form-item">
                                    <label class="layui-form-label">请选择地区</label>
                                    <div class="layui-inline">
                                        <select name="province" id="province" lay-verify="required" lay-search
                                                lay-filter="province">
                                            <option value="">省份</option>
                                        </select>
                                    </div>
                                    <div class="layui-inline">
                                        <select name="city" id="city" lay-verify="required" lay-search
                                                lay-filter="city">
                                            <option value="">地级市</option>
                                        </select>
                                    </div>
                                    <div class="layui-inline">
                                        <select name="district" id="district" lay-verify="required" lay-search>
                                            <option value="">县/区</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="layui-form-item layui-form-text">
                                <label for="L_sign" class="layui-form-label">签名</label>
                                <div class="layui-input-block">
                                    <textarea placeholder="随便写些什么刷下存在感" id="L_sign" name="sign" autocomplete="off"
                                              class="layui-textarea" style="height: 80px;">老王到此一游</textarea>
                                </div>
                            </div>
                            @csrf
                            <div class="layui-form-item">
                                <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit>确认修改</button>
                            </div>
                        </form>
                    </div>


                    <div class="layui-form layui-form-pane layui-tab-item">
                        <div class="layui-form-item">
                            <div class="avatar-add">
                                <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                                <button type="button" class="layui-btn upload-img" id="upload_img">
                                    <i class="layui-icon">&#xe67c;</i>上传头像
                                </button>
                                <img id="portrait"
                                     src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg">
                                <span class="loading"></span>
                            </div>
                        </div>
                    </div>

                    <div class="layui-form layui-form-pane layui-tab-item">
                        <form action="/user/repass" method="post">
                            <div class="layui-form-item">
                                <label for="L_nowpass" class="layui-form-label">当前密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_nowpass" name="nowpass" required lay-verify="required"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_pass" class="layui-form-label">新密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_pass" name="pass" required lay-verify="required"
                                           autocomplete="off" class="layui-input">
                                </div>
                                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
                            </div>
                            <div class="layui-form-item">
                                <label for="L_repass" class="layui-form-label">确认密码</label>
                                <div class="layui-input-inline">
                                    <input type="password" id="L_repass" name="repass" required lay-verify="required"
                                           autocomplete="off" class="layui-input">
                                </div>
                            </div>
                            <div class="layui-form-item">
                                <button class="layui-btn" key="set-mine" lay-filter="*" lay-submit>确认修改</button>
                            </div>
                        </form>
                    </div>

                    <div class="layui-form layui-form-pane layui-tab-item">
                        <ul class="app-bind">
                            <li class="fly-msg app-havebind">
                                <i class="iconfont icon-qq"></i>
                                <span>已成功绑定，您可以使用QQ帐号直接登录Fly社区，当然，您也可以</span>
                                <a href="javascript:;" class="acc-unbind" type="qq_id">解除绑定</a>

                                <!-- <a href="" onclick="layer.msg('正在绑定微博QQ', {icon:16, shade: 0.1, time:0})" class="acc-bind" type="qq_id">立即绑定</a>
                                <span>，即可使用QQ帐号登录Fly社区</span> -->
                            </li>
                            <li class="fly-msg">
                                <i class="iconfont icon-weibo"></i>
                                <!-- <span>已成功绑定，您可以使用微博直接登录Fly社区，当然，您也可以</span>
                                <a href="javascript:;" class="acc-unbind" type="weibo_id">解除绑定</a> -->

                                <a href="" class="acc-weibo" type="weibo_id"
                                   onclick="layer.msg('正在绑定微博', {icon:16, shade: 0.1, time:0})">立即绑定</a>
                                <span>，即可使用微博帐号登录Fly社区</span>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use('upload', function () {
            var upload = layui.upload;

            //执行实例
            var uploadInst = upload.render({
                elem: '#upload_img', //绑定元素
                url: '{{url('user/upload')}}', //上传接口
                method: 'post',
                done: function (res) {
                    if (res.code == 1) {
                        document.getElementById('portrait').src = res.url
                    }
                },
                error: function () {
                    //请求异常回调
                }
            });
        });
    </script>
    <script src="{{@asset('index/select/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{@asset('index/select/js/area.js')}}" type="text/javascript"></script>
    <script src="{{@asset('index/select/js/select.js')}}" type="text/javascript"></script>
    <script type="text/javascript">
        function jg() {
            alert($("#province").val() + $("#city").val() + $("#district").val());
        }
    </script>
@endsection
