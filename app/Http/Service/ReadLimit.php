<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/1/9
 * Time: 14:08
 */

namespace App\Http\Service;


use App\Jobs\ProcessReadIncrement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Session;

class ReadLimit {
    public function handle($article_id){
        $now = $_SERVER['REQUEST_TIME'];
        if (Session::exists('id')){
            $key = Session::get('id');
        }else{
            $key = request()->ip();
        }
        if (Redis::hexists('read_limit', $key.':'.$article_id)){
            $expires =  Redis::hget('read_limit', $key.':'.$article_id);
            if ($expires < $now){
                $this->read($article_id);
                Redis::hset('read_limit', $key.':'.$article_id, $now+config('setting.expires'));
            }
        }else{
            $this->read($article_id);
            Redis::hset('read_limit', $key.':'.$article_id, $now+config('setting.expires'));
        }
    }

    public function read($article_id){
//        $result = DB::table('article')
//            ->where('id', '=', $article_id)
//            ->increment('read');
        dispatch(new ProcessReadIncrement($article_id));
    }
}