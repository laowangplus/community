<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/30
 * Time: 17:56
 */

namespace App\Http\Model\Index;


use App\Exceptions\MessageException;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class Message extends Model {
    protected $table = 'message';

    public static function createMessage($type, $message, $acceptor = 0){
        try{
            $created_at = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            $user_id = \Session::get('id');
            DB::table('message')->insert([
               'type' => $type,
               'message' => $message,
               'acceptor' => $acceptor,
               'user_id' => $user_id,
               'created_at' => $created_at,
            ]);
            $message = DB::table('message')->where([
                'created_at' => $created_at,
                'user_id' => $user_id,
                'acceptor' => $acceptor,
            ])
                 ->select('id')
                 ->first();
            return $message->id;
        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public static function getMessageByUser(){
        $user_id = \Session::get('id');
        $message_ids = Redis::sMembers("user_message:{$user_id}");
        $result = DB::table('message')
            ->whereIn('id', $message_ids)
            ->orderBy('created_at', 'desc')
            ->get();
        if ($result){
            return $result;
        }
    }

    public static function deleteMessage($message_id){
        $user_id = \Session::get('id');

        $res = Redis::srem('user_message:'.$user_id, $message_id);
        if ($res == 1){
            return $res;
        }else{
            return $res;
        }
    }

    public static function clearMessage(){
        $user_id = \Session::get('id');
        $message_ids = Redis::sMembers("user_message:{$user_id}");
        if (!$message_ids){
            return 1;
        }
        $res = 1;
        foreach ($message_ids as $message_id){
            $result = Redis::srem('user_message:'.$user_id, $message_id);
            if ($result == 1){
                continue;
            }else{
                $res = 0;
            }
        }
        if ($res == 1){
            return $res;
        }else{
            return $res;
        }
    }
}