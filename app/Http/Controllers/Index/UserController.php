<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/8
 * Time: 16:12
 */

namespace App\Http\Controllers\Index;


use App\Http\Controllers\Controller;
use App\Http\Model\Index\Article;
use App\Http\Model\Index\Attention;
use App\Http\Model\Index\Category;
use App\Http\Model\Index\Comment;
use App\Http\Model\Index\Message;
use App\Http\Model\Index\User;
use App\Http\Service\MessageDrive;
use App\Validate\BasicInfoCheck;
use App\Validate\SearchCheck;
use App\Validate\SearchCollectionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Psy\Util\Json;

class UserController extends Controller {
    public function home($id = null){
        if ($id == null){
            $id = \Session::get('id');
        }
        $info = User::getUserInfo($id);
        $articles = Article::getArticlesByRecent();
        $comments = Comment::getCommentsByRecent();
        return view('index.user.home', [
            'info' => $info,
            'articles' => $articles,
            'comments' => $comments,
        ]);

    }

    public function index(){
        if (\request()->isMethod('post')){
            $data = SearchCheck::validate();
            Session::put($data);
//            dd(Session::all());
            return redirect('user/article');
        }
        $articles = Article::getArticlesByUser();
        $categorys = Category::getCategoryByIdentity();
        return view('index.user.index', [
            'articles' => $articles,
            'categorys' => $categorys,
        ]);
    }

    public function collection(){
        if (\request()->isMethod('post')){
            $data = SearchCollectionCheck::validate();
            Session::put($data);
//            dd(Session::all());
            return redirect('user/collection');
        }
        $articles = Article::getArticlesByCollection();
        $categorys = Category::getCategoryByIdentity();
        return view('index.user.collection', [
            'articles' => $articles,
            'categorys' => $categorys,
        ]);
    }

    public function attentionList(){
        $users = Attention::getAttentionList();
//        dd($users);
        return view('index.user.attention', [
            'users' => $users,
        ]);
    }

    public function attention($id){
        $status = User::attention($id);
        return Json::encode([
            'code' => 1,
            'status' => $status,
        ]);
    }

    public function indexByMyToAPI(){
        $articles = Article::getArticlesByUser();
        return Json::encode($articles);
    }

    public function indexByCollectionToAPI(){
        $articles = Article::getArticlesByCollection();
        return Json::encode($articles);
    }

    public function set(){
        return view('index.user.set');
    }
    //修改头像
    public function upload(Request $request){
        $path = $request->file('file')->store("storager/user/".date('Y-m-d'));
        User::updateUserImg($path);
        return Json::encode([
            'code' => 1,
            'url' => asset($path),
        ]);
    }
    //修改基本信息
    public function basic(){
        $data = BasicInfoCheck::validate();
        User::updateUserBasic($data);
        return Json::encode([
            'code' => 1,
            'msg' => '修改成功',
        ]);
    }

    public function message(){
//        $message = new MessageDrive();
//        $message->send(1, '老王到此一游', 0, 1069);
        $messages = Message::getMessageByUser();
        return view('index.user.message', [
            'messages' => $messages->toArray(),
        ]);
    }

    public function deleteMessage($message_id){
        $result = Message::deleteMessage($message_id);
        return Json::encode([
            'code' => $result,
        ]);
    }

    public function clearMessage(){
        $result = Message::clearMessage();
        return Json::encode([
            'code' => $result,
        ]);
    }
}