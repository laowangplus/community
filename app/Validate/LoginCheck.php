<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/29
 * Time: 14:42
 */

namespace App\Validate;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\MessageException;

class LoginCheck {
    public static function validate() {
        $validate = Validator::make(Request::all(), [
            'email'    => 'required',
            'pass'     => 'required|min:5|max:12',
            'vercode'  => 'required',
        ]);
        if ($validate->fails()){
            throw new MessageException([
                'msg' => $validate->errors()->all(),
            ]);
        }
        return $validate->validate();
    }
}