<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/21
 * Time: 21:01
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Model\Index\Chat;
use App\Http\Service\ChatServer;

class ChatController extends Controller {
    public function index(){
        return view('index.chat.index');
    }

    public function room(){
        $chat = new ChatServer();
        $token = $chat->setUserToken();
        $user_info = [
            'user_id' => \Session::get('id'),
            'username' => \Session::get('username'),
            'img_url' => \Session::get('img_url')
        ];
        $live_users = $chat->getLiveUsers();

        $chatRecords = Chat::getChatRecord(20);
        return view('index.chat.room', [
            'token' => $token,
            'user_info' => $user_info,
            'live_users' => $live_users,
            'chatRecords' => $chatRecords,
        ]);
    }
}