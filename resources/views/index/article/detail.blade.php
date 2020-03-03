@extends('index.public.index')

@section('title')
    <title>学习分享社区-{{$article->title}}</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{@asset('/index/style/content.css')}}">
@endsection

@section('contain')
    <div class="layui-container">
        <div class="layui-row layui-col-space15">
            <div class="layui-col-md8 content detail">
                <div class="fly-panel detail-box">
                    <h1>
                        {{$article->title}}
                        <a href="javascript:void(0)" id="collection">
                            @if($collection == 1)
                                <i class="layui-icon layui-icon-star-fill" onclick="collection({{$article_id}})"
                                   style="font-size: 25px; color: #1E9FFF;"></i>
                            @elseif($collection == 0)
                                <i class="layui-icon layui-icon-star" onclick="collection({{$article_id}})"
                                   style="font-size: 25px; color: #1E9FFF;"></i>
                            @else
                            @endif
                        </a>
                        <span id="span_top" style="font-size: 12px; float: right">
                            标签：
                        @foreach($article->tag as $tag)
                                <span class="layui-btn layui-btn-xs layui-bg-blue jie-admin"
                                      type="tag">{{ $tag }}</span>
                            @endforeach
                        </span>

                    </h1>
                    <div class="fly-detail-info">
                        <!-- <span class="layui-badge">审核中</span> -->
                        <span class="layui-badge layui-bg-green fly-detail-column">{{$article->classname}}</span>
                        @if($article->accept == 0)
                            <span class="layui-badge" style="background-color: #999;">未结</span>
                        @else
                            <span class="layui-badge" style="background-color: #5FB878;">已结</span>
                        @endif


                        <div class="fly-admin-box" data-id="456">
                            @if($article->top == 1)
                                <span class="layui-btn layui-btn-xs jie-admin" type="set" field="stick"
                                      rank="1">置顶</span>
                            @endif
                            @if($article->essence == 1)
                                <span class="layui-badge layui-bg-red">精帖</span>
                            @endif
                            @if(1 == Session::get('super'))
                                @if($article->top == 0)
                                    <span class="layui-btn layui-btn-xs jie-admin" id="top" type="set" field="stick"
                                          rank="1" onclick="topArticle({{$article_id}})">置顶</span>
                                @else
                                    <span class="layui-btn layui-btn-xs jie-admin" id="top" type="set" field="stick"
                                          rank="0" style="background-color:#ccc;" onclick="topArticle({{$article_id}})">取消置顶</span>
                                @endif
                                @if($article->essence == 0)
                                    <span class="layui-btn layui-btn-xs jie-admin" id="essence" type="set"
                                          field="status"
                                          rank="1" onclick="essence({{$article_id}})">加精</span>
                                @else
                                    <span class="layui-btn layui-btn-xs jie-admin" id="essence" type="set"
                                          field="status" rank="0" style="background-color:#ccc;"
                                          onclick="essence({{$article_id}})">取消加精</span>
                                @endif

                            @endif
                        </div>
                        <span class="fly-list-nums">
            <a href="#comment"><i class="iconfont" title="回答">&#xe60c;</i> {{$article->comment_count}}</a>
            <i class="iconfont" title="人气">&#xe60b;</i> {{$article->read}}
          </span>
                    </div>
                    <div class="detail-about">
                        <a class="fly-avatar" href="../user/home.html">
                            <img src="{{asset($article->img_url)}}" alt="贤心">
                        </a>
                        <div class="fly-detail-user">
                            <a href="{{url('user/home/'.$article->user_id)}}" class="fly-link">
                                <cite>{{$article->username}}</cite>
                                <i class="iconfont icon-renzheng" title="认证信息："></i>
                                <i class="layui-badge fly-badge-vip">VIP3</i>
                            </a>
                            <span>{{$article->create_time}}</span>
                        </div>
                        <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
                            <span style="padding-right: 10px; color: #FF7200">悬赏：{{$article->experience}}飞吻</span>
                            @if($article->user_id == Session::get('id'))
                                <span class="layui-btn layui-btn-xs jie-admin" type="edit"><a
                                            href="{{url('article/edit/'.$article_id)}}">编辑此贴</a></span>
                                <span class="layui-btn layui-btn-xs jie-admin" type="del">删除</span>
                            @endif

                        </div>
                    </div>
                    <div class="detail-body photos" id="editor">
                        {!! $article->content !!}
                    </div>
                </div>

                <div class="fly-panel detail-box" id="flyReply">
                    <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
                        <legend id="comment">回帖</legend>
                    </fieldset>

                    <ul class="jieda" id="jieda">
                        @foreach($comments as $comment)
                            <li data-id="111" class="jieda-daan">
                                <a name="item-1111111111"></a>
                                <div class="detail-about detail-about-reply">
                                    <a class="fly-avatar" href="">
                                        <img src="{{asset($comment->img_url)}}"
                                             alt=" ">
                                    </a>
                                    <div class="fly-detail-user">
                                        <a href="" class="fly-link">
                                            <cite>{{$comment->username}}</cite>
                                            {{--<i class="iconfont icon-renzheng" title="认证信息：XXX"></i>--}}
                                            {{--<i class="layui-badge fly-badge-vip">VIP3</i>--}}
                                        </a>
                                        @if($article->user_id == $comment->user_id)
                                            <span>(楼主)</span>
                                    @endif

                                    <!--
                                        <span style="color:#5FB878">(管理员)</span>
                                        <span style="color:#FF9E3F">（社区之光）</span>
                                        <span style="color:#999">（该号已被封）</span>
                                        -->
                                    </div>

                                    <div class="detail-hits">
                                        <span>{{$comment->create_time}}</span>
                                    </div>
                                    <div id="accept{{$comment->comment_id}}">
                                        @if($comment->caina == 1)
                                            <i class="iconfont icon-caina" title="最佳答案"></i>
                                        @endif
                                    </div>
                                </div>
                                <div class="detail-body jieda-body photos">
                                    {!! $comment->content !!}
                                </div>
                                <div class="jieda-reply">
                                    <span class="jieda-zan zanok" type="zan">
                <i class="iconfont icon-zan"></i>
                <em>{{$comment->praise}}</em>
              </span>
                                    <span type="reply"
                                          onclick="reply('{{$comment->comment_id}}', '{{$comment->user_id}}', '{{$comment->username}}')">
                <i class="iconfont icon-svgmoban53"></i>
                回复
              </span>
                                    <div class="jieda-admin">
                                        {{--<span type="edit">编辑</span>--}}
                                        <span type="del" onclick="del_comment(this, {{$comment->comment_id}})">删除</span>
                                        <span class="jieda-user">
                                            @if($article->user_id == Session::get('id') && $article->accept == 0)
                                                <span class="jieda-accept" type="accept"
                                                      onclick="caina(this, {{$comment->comment_id}}, {{$article_id}})">采纳</span>
                                            @endif
                                        </span>
                                    </div>

                                </div>
                            </li>
                    @endforeach
                    <!-- <li data-id="111">
                            <a name="item-1111111111"></a>
                            <div class="detail-about detail-about-reply">
                                <a class="fly-avatar" href="">
                                    <img src="https://tva1.sinaimg.cn/crop.0.0.118.118.180/5db11ff4gw1e77d3nqrv8j203b03cweg.jpg"
                                         alt=" ">
                                </a>
                                <div class="fly-detail-user">
                                    <a href="" class="fly-link">
                                        <cite>贤心</cite>
                                    </a>
                                </div>
                                <div class="detail-hits">
                                    <span>2017-11-30</span>
                                </div>
                            </div>
                            <div class="detail-body jieda-body photos">
                                <p>蓝瘦那个香菇，这是一条没被采纳的回帖</p>
                            </div>
                            <div class="jieda-reply">
              <span class="jieda-zan" type="zan">
                <i class="iconfont icon-zan"></i>
                <em>0</em>
              </span>
                                <span type="reply">
                <i class="iconfont icon-svgmoban53"></i>
                回复
              </span>
                                <div class="jieda-admin">
                                    <span type="edit">编辑</span>
                                    <span type="del">删除</span>
                                    <span class="jieda-accept" type="accept">采纳</span>
                                </div>
                            </div>
                        </li> -->

                        <!-- 无数据时 -->
                        <!-- <li class="fly-none">消灭零回复</li> -->
                    </ul>

                    <div class="layui-form layui-form-pane">
                        <form action="{{url('comment/add/')}}" method="post">
                            <div class="layui-form-item layui-form-text">
                                <a name="comment"></a>
                                <div class="layui-input-block" id="editor1">
                                </div>
                                <textarea id="content" name="content" hidden="hidden"></textarea>
                            </div>
                            <input hidden name="article_id" value="{{$article_id}}">
                            @csrf
                            <div class="layui-form-item">
                                <input type="hidden" name="jid" value="123">
                                <button class="layui-btn">提交回复</button>
                            </div>
                        </form>
                    </div>
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
                        <a href="http://layim.layui.com/?from=fly" target="_blank" class="fly-zanzhu"
                           time-limit="2017.09.25-2099.01.01" style="background-color: #5FB878;">LayIM 3.0 - layui
                            旗舰之作</a>
                    </div>
                </div>

                <div class="fly-panel" style="padding: 20px 0; text-align: center;">
                    <img src="../../res/images/weixin.jpg" style="max-width: 100%;" alt="layui">
                    <p style="position: relative; color: #666;">微信扫码关注 layui 公众号</p>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{@asset('index/select/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{@asset('/wangEditor/release/wangEditor.min.js')}}"></script>
    <script src="{{@asset('/wangEditor/release/wangEditor.js')}}"></script>

    <script>
        var E = window.wangEditor
        var editor = new E('#editor1')
        // 或者 var editor = new E( document.getElementById('editor') )

        // 自定义菜单配置
        editor.customConfig.menus = [
            'head',  // 标题
            'bold',  // 粗体
            'italic',  // 斜体
            'underline',  // 下划线
            'strikeThrough',  // 删除线
            'foreColor',  // 文字颜色
            'backColor',  // 背景颜色
            'link',  // 插入链接
            'list',  // 列表
            'quote',  // 引用
            'emoticon',  // 表情
            'image',  // 插入图片
            'code',  // 插入代码
        ]

        // 配置服务器端地址
        editor.customConfig.uploadImgServer = "{{url('publish/upload')}}"

        // 自定义文件名
        editor.customConfig.uploadFileName = 'img'

        //编辑区域的z-index默认为10000，可自定义修改
        editor.customConfig.zIndex = 100

        editor.customConfig.uploadImgHooks = {
            before: function (xhr, editor, files) {
                // 图片上传之前触发
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，files 是选择的图片文件
                // 如果返回的结果是 {prevent: true, msg: 'xxxx'} 则表示用户放弃上传
                // return {
                //     prevent: true,
                //     msg: '放弃上传'
                // }
            },
            success: function (xhr, editor, result) {
                // 图片上传并返回结果，图片插入成功之后触发
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            },
            fail: function (xhr, editor, result) {
                // 图片上传并返回结果，但图片插入错误时触发
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象，result 是服务器端返回的结果
            },
            error: function (xhr, editor) {
                // 图片上传出错时触发
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            },
            timeout: function (xhr, editor) {
                // 图片上传超时时触发
                // xhr 是 XMLHttpRequst 对象，editor 是编辑器对象
            },
            // 如果服务器端返回的不是 {errno:0, data: [...]} 这种格式，可使用该配置
            // （但是，服务器端返回的必须是一个 JSON 格式字符串！！！否则会报错）
            customInsert: function (insertImg, result, editor) {
                // 图片上传并返回结果，自定义插入图片的事件（而不是编辑器自动插入图片！！！）
                // insertImg 是插入图片的函数，editor 是编辑器对象，result 是服务器端返回的结果
                // 举例：假如上传图片成功后，服务器端返回的是 {url:'....'} 这种格式，即可这样插入图片：
                var url = result.url
                insertImg(url)
                // result 必须是一个 JSON 格式字符串！！！否则报错
            }
        }


        var $content = $('#content')
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $content.val(html)
        }
        editor.create()

        // 初始化 textarea 的值
        $content.val(editor.txt.html())

        function reply(comment_id, user_id, username) {
            editor.txt.html("<p>@<a href='{{url('user/home')}}/'" + user_id + ">" + username + "</a>:</p>");
        }

        function caina(obj, comment_id, article_id) {
            $.get('{{url('comment/accept')}}/' + comment_id + "/" + article_id, function (res) {
                if (res.code == 1) {
                    $(".jieda-user").remove();
                    document.getElementById('accept' + comment_id).innerHTML = "<i class=\"iconfont icon-caina\" title=\"最佳答案\"></i>";
                }
            })
        }

        function collection(article_id) {
            $.get('{{url('article/collection')}}/' + article_id, function (res) {
                if (res.code == 1) {
                    if (res.status == 1) {
                        document.getElementById('collection').innerHTML = "<i class=\"layui-icon layui-icon-star-fill\" onclick=\"collection({{$article_id}})\" style=\"font-size: 25px; color: #1E9FFF;\"></i>";
                    } else {
                        document.getElementById('collection').innerHTML = "<i class=\"layui-icon layui-icon-star\" onclick=\"collection({{$article_id}})\" style=\"font-size: 25px; color: #1E9FFF;\"></i>";
                    }
                    // document.getElementById('accept'+comment_id).innerHTML = "<i class=\"iconfont icon-caina\" title=\"最佳答案\"></i>";
                }
            })
        }

        function topArticle(article_id) {
            $.get('{{url('article/top')}}/' + article_id, function (res) {
                if (res.code == 1) {
                    if (res.status == 1) {
                        document.getElementById('top').style = "background-color:#ccc;";
                        document.getElementById('top').innerText = "取消置顶";
                    } else {
                        document.getElementById('top').style = "";
                        document.getElementById('top').innerText = "置顶";
                    }
                }
            })
        }

        function essence(article_id) {
            $.get('{{url('article/essence')}}/' + article_id, function (res) {
                if (res.code == 1) {
                    if (res.status == 1) {
                        document.getElementById('essence').style = "background-color:#ccc;";
                        document.getElementById('essence').innerText = "取消加精";
                    } else {
                        document.getElementById('essence').style = "";
                        document.getElementById('essence').innerText = "加精";
                    }
                }
            })
        }

        function del_comment(obj, comment_id) {

            $.get('{{url('comment/del')}}/' + comment_id, function (res) {
                if (res.code == 1) {
                    $(obj).parent('.jieda-admin').parent('.jieda-reply').parent('.jieda-daan').remove();
                }
            })
        }
    </script>
@endsection