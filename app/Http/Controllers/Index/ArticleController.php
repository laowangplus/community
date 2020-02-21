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
use App\Http\Model\Index\Comment;
use App\Http\Service\TagDrive;
use App\Http\Service\YourLike;
use App\Validate\ArticleCheck;
use App\Validate\CommentCheck;
use Illuminate\Http\Request;
use Psy\Util\Json;

class ArticleController extends Controller {
    public function articleByCategory($category_id){
        $articles = Article::getArticlesByCategory($category_id);
        $categorys = Category::getCategoryByIdentity();
        return view('index.article.category', [
            'articles' => $articles,
            'category_id' => $category_id,
            'categorys' => $categorys
        ]);
    }

    public function detail($article_id){
        $article = Article::getArticleDetail($article_id);
        $article->tag = TagDrive::TagToArray($article->tag);
        //增加用户登录态的统计爱好
        YourLike::addLike($article_id);
        YourLike::getLike();
        $comments = Comment::getAllComment($article_id);
        $collection = Article::getArticleCollection($article_id);
        return view('index.article.detail', [
            'article' => $article,
            'comments' => $comments,
            'article_id' => $article_id,
            'collection' => $collection,
        ]);
    }

    public function edit(Request $request, $article_id){
//        dd($_POST);
        if ($request->isMethod('post')){
            $data = ArticleCheck::validate();
            $data['id'] = $article_id;
            Article::updateArticle($data);
            return redirect('/article/detail/'.$article_id);
        }
        $article = Article::getArticleDetail($article_id);
        $categorys = Category::getCategoryByIdentity();
        return view('index.article.edit', [
            'categorys' => $categorys,
            'article' => $article,
            'article_id' => $article_id,
        ]);
    }

    public function comment(){
        $data = CommentCheck::validate();
        Comment::createComment($data);
        return redirect('/article/detail/'.$data['article_id'].'#comment');
    }

    public function del_comment($comment_id){
        Comment::deleteComment($comment_id);
        return \Response::json([
            'code' => 1,
        ]);
    }

    public function accept($comment_id, $article_id){
        Comment::accept($comment_id, $article_id);
        return \Response::json([
            'code' => 1,
        ]);
    }

    public function collection($article_id){
        $status = Article::collection($article_id);
        return \Response::json([
            'code' => 1,
            'status' => $status,
        ]);
    }

    public function top($article_id){
        $status = Article::top($article_id);
        return \Response::json([
            'code' => 1,
            'status' => $status,
        ]);
    }

    //设置为精华文章
    public function essence($article_id){
        $status = Article::essence($article_id);
        return \Response::json([
            'code' => 1,
            'status' => $status,
        ]);
    }

    public function search($keyword){
        $articles = Article::searchArticles($keyword);
        return view('index.article.search_return', [
            'articles' => $articles,
            'keyword' => $keyword
        ]);
    }
}