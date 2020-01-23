<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/29
 * Time: 16:05
 */

namespace App\Http\Model\Index;


use App\Exceptions\ErrorException;
use App\Exceptions\MessageException;
use Doctrine\DBAL\Driver\PDOException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

class User extends Model {
    public static function createUser($data) {
        try {
            $result = DB::table('user')->insert([
                'username' => $data['username'],
                'email'    => $data['email'],
                'password' => md5($data['pass']),
                'created_at' => date('Y-m-d', $_SERVER['REQUEST_TIME']),
            ]);
            if ($result) {
                $token = md5($data['email'] . $_SERVER['REQUEST_TIME']);
                \Cache::set($token, $data['email']);
                dd('/check/' . $token, \Cache::get($token));
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

    public static function userCheck($data) {
        try {
            $result = DB::table('user')->where('email', '=', $data['email'])
                ->where('password', '=', md5($data['pass']))
                ->select('id', 'img_url', 'username', 'sex', 'sign', 'super', 'city', 'email', 'created_at', 'status', 'last_login_ip', 'last_login_time')
                ->first();
            if ($result) {
                if ($result->status == 0) {
                    throw new MessageException([
                        'msg' => '未验证，请到邮箱辅助验证，若未接收到邮件，请重新发送',
                    ]);
                }

                DB::table('user')->where('id', '=', $result->id)
                    ->update([
                        'last_login_ip' => Request::ip(),
                        'last_login_time' => $_SERVER['REQUEST_TIME'],
                    ]);

                \Session::put([
                    'id' => $result->id,
                    'super' => $result->super,
                    'username' => $result->username,
                    'email' => $result->email,
                    'img_url' => asset($result->img_url),
                    'sign' => $result->sign,
                    'city' => $result->city,
                    'sex' => \Config::get('sex.'.$result->sex),
                    'sex_number' => $result->sex,
                    'created_at' => $result->created_at,
                    'last_login_ip' => $result->last_login_ip,
                    'last_login_time' => date('Y-m-d H-i-s', $result->last_login_time),
                ]);
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

    public static function ChangeUserStatus($email) {
        try {
            $result = DB::table('user')->where('email', '=', $email)
                ->update(['status' => 1]);
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

    public static function updateUserImg($url){
        $id = \Session::get('id');
        try{
            DB::table('user')->where('id', '=', $id)
                ->update([
                    'img_url' => $url
                ]);
            \Session::put('img_url', asset($url));
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function updateUserBasic($data){
        $id = \Session::get('id');
        try{
            $city = $data['province'].'-'.$data['city'].'-'.$data['district'];
            $data['city'] = $city;
            unset($data['province']);
            unset($data['district']);
            DB::table('user')->where('id', '=', $id)
                ->update($data);
            \Session::put([
                'username' => $data['username'],
                'email' => $data['username'],
                'sign' => $data['sign'],
                'city' => $data['city'],
                'sex' => \Config::get('sex.'.$data['sex']),
                'sex_number' => $data['sex'],
            ]);
        }catch (PDOException $e){
            return $e->getMessage();
        }
    }

    public static function getUserInfo($id){
        $user = DB::table('user')
            ->where('id', '=', $id)
            ->select('id','username', 'email', 'img_url', 'created_at as create_time', 'city',
                'sign', 'sex')
            ->first();
        if ($user){
            $exist = DB::table('attention')
                ->where([
                    'self_id' => Session::get('id'),
                    'attention_id' => $id,
                ])
                ->first();
            if (!$exist){
                $user->status = 2;
            }else{
                $user->status = $exist->status;
            }
            return $user;
        }else{
            return 0;
        }
    }

    public static function attention($id){
        try{
            $exist = DB::table('attention')
                ->where([
                    'self_id' => Session::get('id'),
                    'attention_id' => $id,
                ])
                ->first();
            if (!$exist){
                DB::table('attention')->insert([
                    'self_id' => Session::get('id'),
                    'attention_id' => $id,
                ]);
                return 1;
            }
            if ($exist->status == 1){
                DB::table('attention')
                    ->where([
                        'self_id' => Session::get('id'),
                        'attention_id' => $id,
                    ])
                    ->update(['status' => 0]);
                return 0;
            }else{
                DB::table('attention')
                    ->where([
                        'self_id' => Session::get('id'),
                        'attention_id' => $id,
                    ])
                    ->update(['status' => 1]);
                return 1;
            }

        }catch (\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public static function getUserFieldFromAll($field){
        $user = DB::table('user')
            ->select("{$field}")
            ->get();
        if ($user){
            return $user;
        }
    }
}