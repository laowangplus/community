<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/8
 * Time: 16:12
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Model\Index\Article;
use App\Http\Model\Index\Sign;
use App\Http\Service\TagStatistics;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller {
    public function index(){
        //猜你喜欢推荐文章
//        dd(\Session::get('sign_status'));
        $like_articles = Article::getArticlesByLike();
        $articles = Article::getTopArticle();
        $sign = Sign::getSignInfo();
        $hot_tags = TagStatistics::getTags();
        return view('index.index', [
            'articles' => $articles,
            'like_articles' => $like_articles,
            'sign' => $sign,
            'hot_tags' => $hot_tags
        ]);
    }
}