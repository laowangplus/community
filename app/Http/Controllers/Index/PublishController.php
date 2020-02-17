<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/28
 * Time: 13:30
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Model\Index\Article;
use App\Http\Model\Index\Category;
use App\Validate\ArticleCheck;
use Illuminate\Http\Request;
use Psy\Util\Json;

class PublishController extends Controller {
    public function add(Request $request){
        if ($request->isMethod('post')){
            $data = ArticleCheck::validate();
            $article_id = Article::createArticle($data);
            return redirect('/article/detail/'.$article_id);
        }
        $categorys = Category::getCategoryByIdentity()->toArray();
        return view('index/publish/add', [
            'categorys' => $categorys
        ]);
    }

    public function upload(Request $request){
        $path = $request->file('img')->store("storager/article/".date('Y-m-d'));
        return Json::encode([
            'url' => asset($path),
        ]);
    }
}