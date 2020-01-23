<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2020/1/9
 * Time: 14:08
 */

namespace App\Http\Service;


class TagDrive {
    public static function TagToArray($tag){
        if ($tag == null){
            return [];
        }else{
            $result = explode(',', $tag);
            return $result;
        }
    }
}