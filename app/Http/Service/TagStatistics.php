<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/13
 * Time: 21:15
 */

namespace App\Http\Service;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class TagStatistics {
    public static function view($article_id){
        $tags = DB::table('tag_article')
            ->where('article_id', '=', $article_id)
            ->get();
        $ret = true;
        foreach ($tags as $tag) {
            $ret = Redis::hIncrBy('tag_statistics', $tag->tag_id, 1);
        }
        return $ret;
    }

    public static function getTags(){
        $tag_ids = self::handleTags();
        $tags = DB::table('tag')
            ->whereIn('id', $tag_ids)
            ->select('tag_name')
            ->get();
        return $tags;
    }

    protected static function handleTags(){
        $ret = Redis::hGetAll('tag_statistics');
        if (!$ret){
            return [];
        }
        arsort($ret);
        $result = [];
        $i = 0;
        foreach ($ret as $tag=>$value){
            if ($i > 50){
                break;
            }
            $i++;
            $result[] = $tag;
        }
        return $result;
    }
}