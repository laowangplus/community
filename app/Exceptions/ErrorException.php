<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/8
 * Time: 12:56
 */

namespace App\Exceptions;

use Psy\Util\Json;

class ErrorException extends BaseException {
    public $code = "500";
    public $msg = "异常操作";
    public $errorCode = "10000";

    public function render($request){
        return response(Json::encode([
            'code' => $this->code,
            'msg' => $this->msg,
            'error' => $this->errorCode
        ]), $this->code);
    }
}