<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/22
 * Time: 0:37
 */

namespace App\Http\Service;


use Illuminate\Support\Facades\Redis;

class ChatServer {
    public function setUserToken() {
        $token = $this->checkToken();
        if ($token) {
            return $token;
        }
        $user_id = \Session::get('id');
        if (!$user_id){
            \Session::put('username', '用户' . $_SERVER['REQUEST_TIME']);
            \Session::put('img_url', '/index/chat/images/user/' . random_int(1, 12) . '.png');
        }
        $date  = \Session::all();
        $token = md5($user_id . '' . $_SERVER['REQUEST_TIME']);
        Redis::hmset($token, $date);
        Redis::expire($token, 7200);
        \Session::put('token', $token);
        return $token;
    }

    public function checkToken() {
        if (!\Session::exists('token')) {
            return false;
        }
        $token = \Session::get('token');
        return $token;

    }

    public function getLiveUsers() {
        $users = Redis::hgetall('live_users');
        $ret   = [];
        foreach ($users as $key => $token) {
            $ret[$key] = Redis::hgetall($token);
        }
        return $ret;
    }
}