<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/10
 * Time: 14:28
 */

namespace App\Http\Model\Index;


use App\Exceptions\ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Psy\Util\Json;

class Sign extends Model {
    //签到接口
    public static function todaySign(){
        $user_id = \Session::get('id');
        $today = date("Y-m-d", $_SERVER['REQUEST_TIME']);
        $now = date("Y-m-d H:i:s", $_SERVER['REQUEST_TIME']);
        $existToday = DB::table('sign')->where([
            'user_id' => $user_id,
            'sign_date' => $today,
        ])->first();
        if ($existToday){
            return Json::encode([
                'sign' => 0,
                'data' => [
                ],
            ]);
        }

        $yesterday = date("Y-m-d", strtotime('-1 day'));
        $existYesterday = DB::table('sign')->where([
            'user_id' => $user_id,
            'sign_date' => $yesterday,
        ])->first();
        if ($existYesterday){
            $days = $existYesterday->days+1;
        }else{
            $days = 1;
        }
        DB::beginTransaction();
        $result = DB::table('sign')
            ->insert([
                'user_id' => $user_id,
                'days' => $days,
                'sign_date' => $today,
                'created_at' => $now,
            ]);
        if ($result){
            $experience = self::experienceRule($days);//编辑功能判断当天可通过签到获取的飞吻数
            \Session::put('sign_status', 1);
            DB::commit();
            return Json::encode([
                'sign' => 1,
                'data' => [
                    'signed' => 1,
                    'experience' => $experience,
                    'days' => $days,
                ],
            ]);
        }else{
            DB::rollBack();
            throw new ErrorException();
        }
    }

    //获取签到信息
    public static function getSignInfo(){
        $user_id = \Session::get('id');

        $today = date("Y-m-d", $_SERVER['REQUEST_TIME']);
        $existToday = DB::table('sign')->where([
            'user_id' => $user_id,
            'sign_date' => $today,
        ])->first();
        if ($existToday){
            $existToday->experience = self::experienceRule($existToday->days);
            return $existToday;
        }

        $yesterday = date("Y-m-d", strtotime('-1 day'));
        $existYesterday = DB::table('sign')->where([
            'user_id' => $user_id,
            'sign_date' => $yesterday,
        ])->first();
        if ($existYesterday){
            $existYesterday->experience = self::experienceRule($existYesterday->days);
            return $existYesterday;
        }else{
            $existYesterday = new self();
            $existYesterday->days = 0;
            $existYesterday->experience = self::experienceRule();
            return $existYesterday;
        }

    }

    //今日是否签到
    public static function signStatus($user_id){
        $today = date("Y-m-d", $_SERVER['REQUEST_TIME']);
        $existToday = DB::table('sign')->where([
            'user_id' => $user_id,
            'sign_date' => $today,
        ])->exists();
        if ($existToday){
            return true;
        }else{
            return false;
        }
    }

    protected static function experienceRule($days=0){
        if ($days<5) {
            return 5;
        }elseif($days>=5&&$days<15){
            return 10;
        }elseif($days>=15&&$days<30){
            return 15;
        }else{
            return 30;
        }
    }
}