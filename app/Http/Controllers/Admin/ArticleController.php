<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/5
 * Time: 13:35
 */

namespace App\Http\Controllers\Admin;


use App\Exceptions\ArticleException;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Request;

class ArticleController extends Controller {
    public function index(){
        $data = DB::table('article')
            ->get();
        return view('admin.article.index', [
            'articles' => $data,
        ]);
    }

    public function add(){
        return view('admin.article.add');
    }

    public function create(Request $request){
        $data = Request::post();
        DB::table('article')
            ->update([
                'content' => $data['editorValue'],
            ]);

    }
}