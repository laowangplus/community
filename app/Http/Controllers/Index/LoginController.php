<?php
/**
 * Created by PhpStorm.
 * User: 老王专用
 * Date: 2019/12/29
 * Time: 13:38
 */

namespace App\Http\Controllers\Index;


use App\Exceptions\ErrorException;
use App\Http\Controllers\Controller;
use App\Http\Model\Index\User;
use App\Validate\LoginCheck;
use App\Validate\RegisterCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use SlimKit\PlusID\Actions\Auth\Login;

class LoginController extends Controller {
    public function login(Request $request){
        if ($request->isMethod('post')){
            $data = LoginCheck::validate();
            User::userCheck($data);
            return redirect('/');
        }
        return view('index/login');
    }

    public function register(Request $request){
        if ($request->isMethod('post')){
            $data = RegisterCheck::validate();
            User::createUser($data);
            return redirect('login');
        }
        return view('index/register');
    }

    public function check($token){
        $email = \Cache::get($token);
        if ($email){
            User::ChangeUserStatus($email);
            \Cache::delete($token);
            return "验证成功";
        }else{
            throw new ErrorException();
        }
    }

    public function logout(){
        \Session::remove('id');
        return redirect('/');
    }
}