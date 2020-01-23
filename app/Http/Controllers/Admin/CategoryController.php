<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/8
 * Time: 16:58
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller {
    public function index(){
        $data = DB::table('category')
            ->get();
        return view('admin.category.index', [
            'categorys' => $data
        ]);
    }
}