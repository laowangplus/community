<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/30
 * Time: 17:56
 */

namespace App\Http\Model\Index;


use App\Exceptions\ErrorException;
use App\Exceptions\MessageException;
use App\Http\Service\SearchService;
use App\Http\Service\YourLike;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class Article extends Model {
    protected $table = 'article';

    public static function getTopArticle() {
        $articles = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('top', '=', 1)
            ->select('title', 'username', 'img_url','classname', 'comment_count', 'top',
                'article.created_at as create_time', 'article.id as article_id',
                'user.id as user_id', 'experience', 'category.id as category_id',
                'accept')
            ->get();
        if ($articles) {
            return $articles;
        }
    }

    public static function getArticlesByCategory($category_id, $pager = 1) {
        $result = DB::table('article')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('category_id', '=', $category_id)
            ->select('title', 'username', 'img_url', 'comment_count',
                'article.created_at as create_time', 'article.id as article_id',
                'user.id as user_id', 'experience', 'accept', 'top', 'essence')
            ->paginate(10);
        if ($result) {
            return $result;
        }
    }

    public static function createArticle($data) {
        try {
            $article_id = DB::table('article')->insertGetId([
                'category_id' => $data['class'],
                'user_id'     => \Session::get('id'),
                'title'       => $data['title'],
                'content'     => $data['content'],
                'tag'         => $data['tag'],
                'experience'  => $data['experience'],
                'created_at'  => date('Y-m-d', $_SERVER['REQUEST_TIME']),
            ]);

            $tags = explode(',', $data['tag']);
//            dd($tags);
            foreach ($tags as $tag){
                $exists = DB::table('tag')
                    ->where('tag_name', '=', strtolower($tag))
                    ->first();
                if ($exists){
                    DB::table('tag_article')->insert([
                        'article_id' => $article_id,
                        'tag_id' => $exists->id,
                    ]);
                }else{
                    $tag_id = DB::table('tag')
                        ->insertGetId([
                            'tag_name' => strtolower($tag)
                        ]);
                    DB::table('tag_article')->insert([
                        'article_id' => $article_id,
                        'tag_id' => $tag_id,
                    ]);
                }
            }

            return $article_id;

        } catch (PDOException $e) {
            throw new ErrorException([
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public static function getAllArticle() {
        $articles = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->select('title', 'username', 'classname', 'comment_count',
                'article.created_at as create_time', 'article.id as article_id',
                'user.id as user_id', 'experience')
            ->get();
        if ($articles) {
            return $articles;
        }
    }

    public static function getArticleSimple($id){
        $article = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->where('article.id', '=', $id)
            ->select('article.id as article_id', 'user_id', 'classname', 'title')
            ->first();
        if ($article) {
            return $article;
        }
    }

    public static function getArticleDetail($id) {
        $article = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('article.id', '=', $id)
            ->select('article.id as article_id', 'classname', 'username', 'img_url', 'user.id as user_id',
                'article.created_at as create_time', 'experience', 'comment_count',
                'read', 'content', 'tag', 'title', 'accept', 'category.id as category_id',
                'top', 'essence')
            ->first();
        if ($article) {
            return $article;
        }
    }

    public static function updateArticle($data) {
        try {
            DB::table('article')->where('id', '=', $data['id'])
                ->update([
                    'category_id' => $data['class'],
                    'user_id'     => \Session::get('id'),
                    'tag'         => $data['tag'],
                    'title'       => $data['title'],
                    'content'     => $data['content'],
                    'experience'  => $data['experience'],
                    'created_at'  => date('Y-m-d', $_SERVER['REQUEST_TIME']),
                ]);

            $tags = explode(',', $data['tag']);
//            dd($tags);
            $old_tags = DB::table('tag_article')
                ->where('article_id', '=', $data['id'])
                ->get();
//            dd($old_tags, $data['id']);
            //exists_tags数组用于存放不更新的tag
            $exists_tags = [];
            foreach ($tags as $tag){
                $exists = DB::table('tag')
                    ->where('tag_name', '=', strtolower($tag))
                    ->first();
                if ($exists){
                    $flag = 0;
                    //判断新录入的tag原先是否已存在
                    foreach ($old_tags as $old_tag){
                        if ($old_tag->tag_id == $exists->id){
                            $flag = 1;
                        }
                    }
                    if ($flag != 0){
                        $exists_tags[] = $exists->id;
                        continue;
                    }
                    DB::table('tag_article')->insert([
                        'article_id' => $data['id'],
                        'tag_id' => $exists->id,
                    ]);
                }else{
                    $tag_id = DB::table('tag')
                        ->insertGetId([
                            'tag_name' => strtolower($tag)
                        ]);
                    DB::table('tag_article')->insert([
                        'article_id' => $data['id'],
                        'tag_id' => $tag_id,
                    ]);
                }
            }
            //删除tag_article表中旧的tag标签
            foreach ($old_tags as &$old_tag){
                if (!in_array($old_tag->tag_id, $exists_tags)){
                    DB::table('tag_article')
                        ->where('id', '=', $old_tag->id)
                        ->delete();
                }
            }
        } catch (PDOException $e) {
            throw new ErrorException([
                'msg' => $e->getMessage(),
            ]);
        }
    }

    public static function collection($article_id) {
        try {
            $collection = DB::table('collection')->where('article_id', '=', $article_id)
                ->where('user_id', '=', \Session::get('id'))
                ->first();
            if ($collection) {
                if ($collection->status == 0) {
                    DB::table('collection')->where('article_id', '=', $article_id)
                        ->where('user_id', '=', \Session::get('id'))
                        ->update([
                            'status' => 1
                        ]);
                    return 1;
                } else {
                    DB::table('collection')->where('article_id', '=', $article_id)
                        ->where('user_id', '=', \Session::get('id'))
                        ->update([
                            'status' => 0
                        ]);
                    return 0;
                }

            } else {
                DB::table('collection')->insert([
                    'article_id' => $article_id,
                    'user_id'    => \Session::get('id'),
                    'status'     => 1,
                ]);
                return 1;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }

    }

    public static function getArticleCollection($article_id) {
        $result = DB::table('collection')
            ->where('article_id', '=', $article_id)
            ->where('user_id', '=', \Session::get('id'))
            ->first();
        if ($result) {
            return $result->status;
        } else {
            return 0;
        }
    }

    public static function top($article_id) {
        try {
            $top = DB::table('article')->where('id', '=', $article_id)
                ->select('top')
                ->first();
            if ($top->top == 0) {
                DB::table('article')->where('id', '=', $article_id)
                    ->update([
                        'top' => 1
                    ]);
                return 1;
            } else {
                DB::table('article')->where('id', '=', $article_id)
                    ->update([
                        'top' => 0
                    ]);
                return 0;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function essence($article_id) {
        try {
            $top = DB::table('article')->where('id', '=', $article_id)
                ->select('essence')
                ->first();
            if ($top->essence == 0) {
                DB::table('article')->where('id', '=', $article_id)
                    ->update([
                        'essence' => 1
                    ]);
                return 1;
            } else {
                DB::table('article')->where('id', '=', $article_id)
                    ->update([
                        'essence' => 0
                    ]);
                return 0;
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public static function getArticlesByUser() {
        $search = [];
        if (\Session::exists('article_title') && !empty(\Session::get('article_title'))) {
            $search[] = ['article.title', '=', \Session::get('article_title')];
        }
        if (\Session::exists('article_month') && !empty(\Session::get('article_month'))) {
            $search[] = ['article.created_at', '>', date('Y-m-d H:i:s', strtotime(\Session::get('article_month')))];
            $search[] = ['article.created_at', '<', date('Y-m-d H:i:s', strtotime("+1 month". \Session::get('article_month')))];
        }
        if (\Session::exists('article_category') && !empty(\Session::get('article_category'))) {
            $search[] = ['category.id', '=', \Session::get('article_category')];
        }
//        dd($search);
        $article = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('user.id', '=', \Session::get('id'))
            ->where($search)
            ->select('article.id as article_id', 'classname', 'username', 'img_url', 'user.id as user_id',
                'article.created_at as create_time', 'experience', 'comment_count',
                'read', 'tag', 'title', 'accept', 'category.id as category_id',
                'top', 'essence')
            ->paginate(10);
        if ($article) {
            return $article;
        }
    }

    public static function getArticlesByCollection() {
        $search = [];
        if (\Session::exists('collection_title') && !empty(\Session::get('collection_title'))) {
            $search[] = ['article.title', '=', \Session::get('collection_title')];
        }
        if (\Session::exists('collection_month') && !empty(\Session::get('collection_month'))) {
            $search[] = ['article.created_at', '>', date('Y-m-d H:i:s', strtotime(\Session::get('collection_month')))];
            $search[] = ['article.created_at', '<', date('Y-m-d H:i:s', strtotime("+1 month". \Session::get('collection_month')))];
        }
        if (\Session::exists('collection_category') && !empty(\Session::get('collection_category'))) {
            $search[] = ['category.id', '=', \Session::get('collection_category')];
        }
//        dd($search);
        $article = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('collection', 'collection.article_id', '=', 'article.id')
            ->where('article.user_id', '=', \Session::get('id'))
            ->where($search)
            ->select('article.id as article_id', 'classname', 'collection_time',
                'article.created_at as create_time', 'experience', 'comment_count',
                'read', 'tag', 'title', 'accept', 'category.id as category_id',
                'top', 'essence')
            ->paginate(10);
        if ($article) {
            return $article;
        }
    }

    public static function getArticleCount() {
        $result = DB::table('article')->count();
        return $result;
    }

    public static function getArticlesByRecent(){
        $now = date('Y-m-d H:i:s');
        $result = DB::table('article')
            ->where('user_id', '=', \Session::get('id'))
            ->where('created_at', '>', date('Y-m-d H:i:s', strtotime("{$now} -1 month")))
            ->select('article.id as article_id', 'created_at', 'read', 'comment_count',
                'top', 'essence', 'title')
            ->orderBy('created_at', 'desc')
            ->get();
        if ($result){
            return $result;
        }
    }

    public static function getArticlesByLike(){
        $user_id = \Session::get('id');
        if (!$user_id){
            return [];
        }
        $tags = YourLike::getLike();
        $articles = DB::table('tag_article')
            ->whereIn('tag_id', $tags)
            ->select('article_id')
            ->get();
        $article_ids = [];
        foreach ($articles as $article){
            $article_ids[] = $article->article_id;
        }

        $articles = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
//            ->whereExists(function ($query)use ($tags){
//                $query->from('tag_article')
//                    ->whereIn('tag_id', $tags)
//                    ->select('article_id as id');
//            })
            ->whereIn('article.id', $article_ids)
            ->select('title', 'username', 'img_url', 'classname', 'comment_count',
                'article.created_at as create_time', 'article.id as article_id',
                'user.id as user_id', 'experience')
            ->get();
        return $articles;
    }

    public static function searchArticles($keyword){
        $service =new SearchService();

        $articles = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->select('title', 'username', 'classname', 'article.id as article_id', 'tag', 'content')
            ->get();

        foreach ($articles as $data){
            $service->addArticle($data);
        }

        try{
            $article_ids = $service->searchArticle($keyword);

            $articles = DB::table('article')
                ->join('category', 'category.id', '=', 'category_id')
                ->join('user', 'user.id', '=', 'user_id')
                ->whereIn('article.id',$article_ids)
                ->select('title', 'username', 'classname', 'comment_count',
                    'article.created_at as create_time', 'article.id as article_id',
                    'user.id as user_id', 'experience', 'accept', 'top', 'essence')
                ->paginate(20);
            return $articles;
        }catch (\Exception $exception){
            $service->createArticleIndex();
            $articles = DB::table('article')
                ->join('category', 'category.id', '=', 'category_id')
                ->join('user', 'user.id', '=', 'user_id')
                ->select('title', 'username', 'classname', 'article.id as article_id', 'tag', 'content')
                ->get();

            foreach ($articles as $data){
                $service->addArticle($data);
            }
        }



    }

}