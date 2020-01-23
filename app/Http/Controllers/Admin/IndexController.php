<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/4
 * Time: 23:04
 */
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class IndexController extends Controller {
    public function index(){
        return view('admin.index.index');
    }
}