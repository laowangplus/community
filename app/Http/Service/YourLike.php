<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/1/29
 * Time: 14:19
 */

namespace App\Http\Service;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class YourLike {
    public static function addLike($article_id) {
        $user_id = Session::get('id');
        $tags = DB::table('tag_article')
            ->where('article_id', '=', $article_id)
            ->get();
        $ret = true;
        foreach ($tags as $tag) {
            $ret = Redis::hIncrBy('user_like' . $user_id, $tag->tag_id, 1);
        }
        return $ret;
    }

    public static function getLike(){
        $user_id = Session::get('id');
        $ret = Redis::hGetAll('user_like'.$user_id);
        if (!$ret){
            return [];
        }
        arsort($ret);
        $result = [];
        $i = 0;
        foreach ($ret as $tag=>$value){
            if ($i > 2){
                break;
            }
            $i++;
            $result[] = $tag;
        }
        return $result;
    }
}