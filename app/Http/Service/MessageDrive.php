<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/1/16
 * Time: 15:50
 */

namespace App\Http\Service;



use App\Http\Model\Index\Article;
use App\Http\Model\Index\Message;
use App\Http\Model\Index\User;
use Illuminate\Support\Facades\Redis;

class MessageDrive {
    /**
     * @param $type 0为广播消息，1为评论通知，2为回复通知，3为回答通知，4为私信通知
     * @param string $message
     * @param int $acceptor
     * @param int $article_id
     * @return string
     */
    public function send($type, $message = "欢迎来到社区", $acceptor = 0, $article_id=0){
        $result = $this->handleMessage($type, $message, $article_id);
        $article = $result['article'];
        if (!$article){
            $message_id = Message::createMessage($type, $result['message'], $acceptor);
            $this->cacheMessageID($type, $message_id, $acceptor);
        }else{
            $message_id = Message::createMessage($type, $result['message'], $article->user_id);
            $this->cacheMessageID($type, $message_id, $article->user_id);
        }
        return $message_id;
    }

    private function cacheMessageID($type, $message_id, $acceptor = 0){
        if ($type == 0){
            $members = Redis::sMembers('user_message');
            $users = User::getUserFieldFromAll('id');
            if (!$members){
                foreach ($users as $user){
                    Redis::sAdd('user_message', $user->id);
                    Redis::sAdd("user_message:{$user->id}", $message_id);
                }
            }else{
                foreach ($users as $user){
                    Redis::sAdd("user_message:{$user->id}", $message_id);
                }
            }
        }else{
            Redis::sAdd("user_message:{$acceptor}", $message_id);
        }
    }

    private function handleMessage($type, $message, $article_id = 0){
        $article = [];
        if ($type == 0){
            $message = "系统消息：".$message;
        }elseif ($type == 1){
            $username = \Session::get('username');
            $user_id = \Session::get('id');
            $article = Article::getArticleSimple($article_id);
            $message = "<a href=\"".url('user/home/'.$user_id)."\" target=\"_blank\"><cite>{$username}</cite></a>评论了您的{$article->classname}<a target=\"_blank\" href=\"".url('article/detail/'.$article->article_id)."\"><cite>{$article->title}</cite></a>";
        }elseif ($type == 2){
            $username = \Session::get('username');
            $user_id = \Session::get('id');
            $article = Article::getArticleSimple($article_id);
            $message = "<a href=\"".url('user/home/'.$user_id)."\" target=\"_blank\"><cite>{$username}</cite></a>回复了您在<a target=\"_blank\" href=\"".url('article/detail/'.$article->article_id)."\"><cite>{$article->title}</cite></a>的评论";
        }elseif ($type == 3){
            $username = \Session::get('username');
            $user_id = \Session::get('id');
            $article = Article::getArticleSimple($article_id);
            $message = "<a href=\"".url('user/home/'.$user_id)."\" target=\"_blank\"><cite>{$username}</cite></a>回答了您的{$article->classname}<a target=\"_blank\" href=\"".url('article/detail/'.$article->article_id)."\"><cite>{$article->title}</cite></a>";
        }elseif ($type == 4){
            $username = \Session::get('username');
            $user_id = \Session::get('id');
            $message = "<a href=\"".url('user/home/'.$user_id)."\" target=\"_blank\"><cite>{$username}</cite></a>私信了您";
        }
        return [
            'message' => $message,
            'article' => $article,
        ];
    }
}