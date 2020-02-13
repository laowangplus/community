<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/2/10
 * Time: 14:26
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Model\Index\Sign;

class SignController extends Controller {
    public function todaySign(){
        return Sign::todaySign();
    }
}