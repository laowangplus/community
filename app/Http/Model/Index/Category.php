<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/30
 * Time: 17:56
 */

namespace App\Http\Model\Index;


use App\Exceptions\ErrorException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model {
    protected $table = 'category';

    public static function getCategoryByIdentity(){
        $result = DB::table('category')
            ->get();
        return $result;
    }
}