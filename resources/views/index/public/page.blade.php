<div style="text-align: center">
    <div class="laypage-main">
        @if($articles->total() <=0 )
        @elseif($articles->total() > 1 && $articles->total() < 5)
            @if($articles->currentPage() > 1)
                <a href="{{$articles->perPage()}}" class="laypage-last" title="首页">首页</a>
            @endif
            @for($i=1; $i<=$articles->total()+1; $i++)
                @if($i == $articles->currentPage())
                    <span class="laypage-curr">{{$i}}</span>
                @else
                    <a href="?page={{$i}}">{{$i}}</a>
                @endif
            @endfor
            <a href="{{ $articles->lastPage() }}" class="laypage-last" title="尾页">尾页</a>
        @else
            @if($articles->currentPage() > 1)
                <a href="{{$articles->perPage()}}" class="laypage-last" title="首页">首页</a>
            @endif
            @if($articles->currentPage() >= 5)
                <span>…</span>
            @endif
            @if($articles->currentPage() < 5)
                @for($i=1; $i<=5; $i++)
                    @if($i == $articles->currentPage())
                        <span class="laypage-curr">{{$i}}</span>
                    @else
                        <a href="?page={{$i}}">{{$i}}</a>
                    @endif
                @endfor
            @elseif($articles->currentPage() >= 5 && $articles->currentPage() < $articles->total()-5)
                @for($i=$articles->currentPage()-2; $i<=$articles->currentPage()+2; $i++)
                    @if($i == $articles->currentPage())
                        <span class="laypage-curr">{{$i}}</span>
                    @else
                        <a href="?page={{$i}}">{{$i}}</a>
                    @endif
                @endfor
            @else
                @for($i=$articles->total()-4; $i<=$articles->total(); $i++)
                    @if($i == $articles->currentPage())
                        <span class="laypage-curr">{{$i}}</span>
                    @else
                        <a href="?page={{$i}}">{{$i}}</a>
                    @endif
                @endfor
            @endif

            @if($articles->currentPage() < $articles->total()-5)
                <span>…</span>
            @endif
            <a href="{{ $articles->lastPage() }}" class="laypage-last" title="尾页">尾页</a>
        @endif

        {{--<span class="laypage-curr">1</span>--}}
        {{--<a href="/jie/page/2/">2</a>--}}
        {{--<a href="/jie/page/3/">3</a>--}}
        {{--<a href="/jie/page/4/">4</a>--}}
        {{--<a href="/jie/page/5/">5</a>--}}
        {{--<span>…</span>--}}
        {{--<a href="/jie/page/148/" class="laypage-last" title="尾页">尾页</a>--}}
        {{--<a href="/jie/page/2/" class="laypage-next">下一页</a>--}}
    </div>
</div>