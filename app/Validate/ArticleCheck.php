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

class ArticleCheck {
    public static function validate() {
        $validate = Validator::make(Request::all(), [
            'class'    => 'integer',
            'title' => 'required',
            'content' => 'required',
            'experience' => 'required',
            'vercode' => 'required',
            'tag' => 'required',
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