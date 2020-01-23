<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/29
 * Time: 14:42
 */

namespace App\Validate;


use App\Exceptions\MessageException;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class BasicInfoCheck {
    public static function validate() {
        $validate = Validator::make(Request::all(), [
            'email'    => 'required|email',
            'username' => 'required',
            'sex' => 'required|integer',
            'province' => 'required',
            'city' => 'required',
            'district' => 'required',
            'sign' => 'max:60',
        ]);
        if ($validate->fails()){
            throw new MessageException([
                'msg' => $validate->errors()->all(),
            ]);
        }else{
            return $validate->validate();
        }

    }
}