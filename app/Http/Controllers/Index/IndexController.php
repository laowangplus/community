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
use Illuminate\Support\Facades\DB;

class IndexController extends Controller {
    public function index(){
        $articles = Article::getTopArticle();
        return view('index.index', [
            'articles' => $articles
        ]);
    }
}