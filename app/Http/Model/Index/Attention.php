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
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class Attention extends Model {
    protected $table = 'article';

    public static function getTopArticle() {
        $articles = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('top', '=', 1)
            ->select('title', 'username', 'classname', 'comment_count', 'top',
                'article.created_at as create_time', 'article.id as article_id',
                'user.id as user_id', 'experience')
            ->get();
        if ($articles) {
            return $articles;
        }
    }

    public static function getArticlesByCategory($category_id, $pager = 1) {
        $result = DB::table('article')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('category_id', '=', $category_id)
            ->select('title', 'username', 'comment_count',
                'article.created_at as create_time', 'article.id as article_id',
                'user.id as user_id', 'experience', 'accept', 'top', 'essence')
            ->paginate(1);
        if ($result) {
            return $result;
        }
    }

    public static function createArticle($data) {
        try {
            $result = DB::table('article')->insert([
                'category_id' => $data['class'],
                'user_id'     => \Session::get('id'),
                'title'       => $data['title'],
                'content'     => $data['content'],
                'tag'         => $data['tag'],
                'experience'  => $data['experience'],
                'created_at'  => date('Y-m-d', $_SERVER['REQUEST_TIME']),
            ]);
            if ($result) {
                return True;
            } else {
                return false;
            }
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

    public static function getArticleDetail($id) {
        $article = DB::table('article')
            ->join('category', 'category.id', '=', 'category_id')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('article.id', '=', $id)
            ->select('classname', 'username', 'img_url', 'user.id as user_id',
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
            $result = DB::table('article')->where('id', '=', $data['id'])
                ->update([
                    'category_id' => $data['class'],
                    'user_id'     => \Session::get('id'),
                    'tag'         => $data['tag'],
                    'title'       => $data['title'],
                    'content'     => $data['content'],
                    'experience'  => $data['experience'],
                    'created_at'  => date('Y-m-d', $_SERVER['REQUEST_TIME']),
                ]);
            if ($result) {
                return True;
            } else {
                return false;
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
            ->paginate(2);
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
            ->paginate(2);
        if ($article) {
            return $article;
        }
    }

    public static function getArticleCount() {
        $result = DB::table('article')->count();
        return $result;
    }

    public static function getAttentionList(){
        $result = DB::table('attention')
            ->join('user', 'user.id', '=', 'attention.attention_id')
            ->where('self_id', '=', \Session::get('id'))
            ->get();
        if ($result){
            return $result;
        }
    }

}