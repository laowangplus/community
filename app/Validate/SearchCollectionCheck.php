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

class SearchCollectionCheck {
    public static function validate() {
        $validate = Validator::make(Request::all(), [
            'collection_title' => '',
            'collection_month' => '',
            'collection_category' => '',

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