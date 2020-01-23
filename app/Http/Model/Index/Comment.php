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
use App\Http\Service\MessageDrive;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model {
    protected $table = 'comment';

    public static function getAllComment($article_id){
        $articles = DB::table('comment')
            ->join('user', 'user.id', '=', 'user_id')
            ->where('article_id', '=', $article_id)
            ->orderBy('comment.created_at', 'desc')
            ->select('comment.id as comment_id', 'username', 'img_url', 'comment.created_at as create_time',
                'user.id as user_id', 'praise', 'content', 'caina')
            ->get();
        if ($articles){
            return $articles;
        }
    }

    public static function createComment($data){
        try{;
            $data['user_id'] = \Session::get('id');
            $data['ip'] = \Request::ip();
            $data['created_at'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            DB::table('comment')->insert($data);
            DB::table('article')->where('id','=',$data['article_id'])->increment('comment_count');
            $message = new MessageDrive();
            $message->send(1, '老王到此一游', 0, $data['article_id']);
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public static function deleteComment($comment_id){
        try{
            $comment = DB::table('comment')->where('id', '=', $comment_id)
                ->first();
            DB::table('comment')->where('id', '=', $comment_id)
                ->delete();
            DB::table('article')->where('id','=',$comment->article_id)->decrement('comment_count');
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public static function accept($comment_id, $article_id){
        try{
            $result = DB::table('comment')->where('article_id', '=', $article_id)
                ->where('caina', '=', 1)
                ->count();
            if ($result >=1 ){
                throw new MessageException([
                    'code' => 200,
                    'msg' => '已采纳，请勿重复操作',
                    'errorCode' => 0
                ]);
            }
            DB::table('comment')->where('id', '=', $comment_id)
                ->update([
                    'caina' => 1
                ]);
            DB::table('article')->where('id', '=', $article_id)
                ->update([
                    'accept' => 1
                ]);
        }catch (PDOException $e){
            throw new \Exception($e->getMessage());
        }

    }

    public static function getCommentsByRecent(){
        $now = date('Y-m-d H:i:s');
        $result = DB::table('comment')
            ->join('article', 'article.id', '=', 'article_id')
            ->where('comment.user_id', '=', \Session::get('id'))
            ->where('comment.created_at', '>', date('Y-m-d H:i:s', strtotime("{$now} -1 month")))
            ->select('comment.id as comment_id', 'comment.content as content', 'article.title as title',
                'comment.created_at as created_at')
            ->orderBy('comment.created_at', 'desc')
            ->get();
        if ($result){
            return $result;
        }
    }

}