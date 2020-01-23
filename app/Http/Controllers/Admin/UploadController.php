<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/8
 * Time: 14:47
 */

namespace App\Http\Controllers\Admin;

use Psy\Util\Json;
use Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller {
    public function image(Request $request){
        $path = Request::file('file')->store('image');
        return Json::encode([
            'path' => $path
        ]);
    }
}