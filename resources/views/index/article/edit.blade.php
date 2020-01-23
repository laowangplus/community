@extends('index.public.index')

@section('title')
    <title>编辑帖子或者提问</title>
@endsection

@section('css')
    <link rel="stylesheet" href="{{@asset('/wangEditor/release/wangEditor.css')}}">
    <link rel="stylesheet" href="{{@asset('/wangEditor/release/wangEditor.min.css')}}">
    <link rel="stylesheet" href="{{@asset('/index/style/content.css')}}">
    <link rel="stylesheet" href="{{@asset('/tag/css/css.css')}}">
@endsection

@section('contain')
    <div class="layui-container fly-marginTop">
        <div class="fly-panel" pad20 style="padding-top: 5px;">
            {{--<div class="fly-none">没有权限</div>--}}
            <div class="layui-form layui-form-pane">
                <div class="layui-tab layui-tab-brief" lay-filter="user">
                    <ul class="layui-tab-title">
                        <li class="layui-this">发表新帖<!-- 编辑帖子 --></li>
                    </ul>
                    <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
                        <div class="layui-tab-item layui-show">
                            <form action="" method="post">
                                <div class="layui-row layui-col-space15 layui-form-item">
                                    <div class="layui-col-md3">
                                        <label class="layui-form-label">所在专栏</label>
                                        <div class="layui-input-block">
                                            <select lay-verify="required" name="class" lay-filter="column">
                                                <option></option>
                                                @foreach($categorys as $category)
                                                    @if($category->id == $article->category_id)
                                                        <option value="{{$category->id}}"
                                                                selected>{{$category->classname}}</option>
                                                    @else
                                                        <option value="{{$category->id}}">{{$category->classname}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="layui-col-md9">
                                        <label for="L_title" class="layui-form-label">标题</label>
                                        <div class="layui-input-block">
                                            <input type="text" id="L_title" name="title" required lay-verify="required"
                                                   autocomplete="off" class="layui-input" value="{{$article->title}}">
                                        </div>
                                    </div>
                                </div>
                            {{--<div class="layui-row layui-col-space15 layui-form-item layui-hide" id="LAY_quiz">--}}
                            {{--<div class="layui-col-md3">--}}
                            {{--<label class="layui-form-label">所属产品</label>--}}
                            {{--<div class="layui-input-block">--}}
                            {{--<select name="project">--}}
                            {{--<option></option>--}}
                            {{--<option value="layui">layui</option>--}}
                            {{--<option value="独立版layer">独立版layer</option>--}}
                            {{--<option value="独立版layDate">独立版layDate</option>--}}
                            {{--<option value="LayIM">LayIM</option>--}}
                            {{--<option value="Fly社区模板">Fly社区模板</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="layui-col-md3">--}}
                            {{--<label class="layui-form-label" for="L_version">版本号</label>--}}
                            {{--<div class="layui-input-block">--}}
                            {{--<input type="text" id="L_version" value="" name="version" autocomplete="off" class="layui-input">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="layui-col-md6">--}}
                            {{--<label class="layui-form-label" for="L_browser">浏览器</label>--}}
                            {{--<div class="layui-input-block">--}}
                            {{--<input type="text" id="L_browser"  value="" name="browser" placeholder="浏览器名称及版本，如：IE 11" autocomplete="off" class="layui-input">--}}
                            {{--</div>--}}
                            {{--</div>--}}
                        </div>
                        <div class="layui-form-item layui-form-text">
                            <div id="toolbar" class="toolbar" style="border: 1px solid #ccc;">
                            </div>
                            <div style="padding: 5px 0; color: #ccc"></div>
                            <div class="layui-input-block" id="editor" style="height: 400px; border: 1px solid #ccc;">
                                {!! $article->content !!}
                            </div>
                            <textarea id="text1" name="content" hidden="hidden"></textarea>
                        </div>

                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">标签</label>
                                    {{--<i class="layui-btn layui-btn-xs layui-btn-radius layui-btn-radius" style="margin-top: 7px; margin-left: 5px">666</i>--}}
                                    <div id="L_label" class="layui-input-inline" style="width: auto; border: 1px solid #e6e6e6; height: 36px">
                                        {{--<input id="mysql" type="text" class="layui-btn layui-btn-xs layui-btn-radius layui-btn-radius" style="margin-top: 8px; margin-left: 8px; width: 50px" name="mysql" value="mysql">--}}
                                        <div class="tagsinput-primary form-group">
                                            <input name="tag" id="tagsinputval" class="tagsinput" data-role="tagsinput" value="{{$article->tag}}" placeholder="输入后回车">
                                        </div>
                                    </div>
                            </div>
                        </div>


                        <div class="layui-form-item">
                            <div class="layui-inline">
                                <label class="layui-form-label">悬赏飞吻</label>
                                <div class="layui-input-inline" style="width: 190px;">
                                    <select name="experience">
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="50">50</option>
                                        <option value="60">60</option>
                                        <option value="80">80</option>
                                    </select>
                                </div>
                                <div class="layui-form-mid layui-word-aux">发表后无法更改飞吻</div>
                            </div>
                        </div>
                        <div class="layui-form-item">
                            <label for="L_vercode" class="layui-form-label">验证码</label>
                            <div class="layui-input-inline">
                                <input type="text" id="L_vercode" name="vercode" required lay-verify="required"
                                       placeholder="请输入验证码" autocomplete="off" class="layui-input">
                            </div>
                            <div class="layui-form-mid">
                                <img src="{{captcha_src()}}" style="cursor: pointer"
                                     onclick="this.src='{{captcha_src()}}'+Math.random()">
                            </div>
                        </div>
                        @csrf
                        <div class="layui-form-item">
                            <button class="layui-btn" lay-filter="*">立即发布</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script src="{{@asset('index/select/js/jquery.min.js')}}" type="text/javascript"></script>
    <script src="{{@asset('/wangEditor/release/wangEditor.min.js')}}"></script>
    <script src="{{@asset('/wangEditor/release/wangEditor.js')}}"></script>
    <script src="{{@asset('/tag/js/tagsinput.js')}}"></script>


    <script>
        var E = window.wangEditor
        var editor = new E('#toolbar', '#editor')
        // 或者 var editor = new E( document.getElementById('editor') )


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


        var $text1 = $('#text1')
        editor.customConfig.onchange = function (html) {
            // 监控变化，同步更新到 textarea
            $text1.val(html)
        }
        editor.create()

        // 初始化 textarea 的值
        $text1.val(editor.txt.html())


        function label(label) {
            console.log(label)
            if($("#"+label).val() !== label){
                $("#L_label").html($("#L_label").html() + "<input id='"+label+"' type=\"text\" class=\"layui-btn layui-btn-xs layui-btn-radius layui-btn-radius\" style=\"margin-top: 8px; margin-left: 8px; width: 50px\" name=\""+label+"\" value=\""+label+"\">")
            }else{
                $("#"+label).remove()
            }

        }
    </script>
@endsection