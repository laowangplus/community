<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/23
 * Time: 1:54
 */

namespace App\Http\Model\Index;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chat extends Model {
    public static function getChatRecord($number=20){
        $data = DB::table('chat')->limit($number)->get();
        return $data;
    }
}