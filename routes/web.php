<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/index', 'Admin\IndexController@index');

//后台
//文章管理
Route::get('/admin/article', 'Admin\ArticleController@index');
Route::get('/admin/article/add', 'Admin\ArticleController@add');
Route::post('/admin/article/create', 'Admin\ArticleController@create');

//分类管理
Route::get('/admin/category', 'Admin\CategoryController@index');

//文件提交
Route::post('/admin/upload/image', 'Admin\UploadController@image');













//前端首页
Route::get('/', 'Index\IndexController@index');

//登录注册
Route::get('/login', 'Index\LoginController@login');
Route::post('/login', 'Index\LoginController@login');
Route::get('/register', 'Index\LoginController@register');
Route::post('/register', 'Index\LoginController@register');

//登出
Route::get('/logout', 'Index\LoginController@logout');

//发表帖子
Route::get('publish/add', 'Index\PublishController@add');
Route::post('publish/add', 'Index\PublishController@add');

//我的首页
Route::get('user/home/{id?}', 'Index\UserController@home');

//关注
Route::get('user/attention/', 'Index\UserController@attentionList');
Route::get('user/attention/{id}', 'Index\UserController@attention');

//分类文章
Route::get('article/category/{id}', 'Index\ArticleController@articleByCategory');


//个人设置
Route::get('user/set', 'Index\UserController@set');
//头像修改
Route::post('user/upload', 'Index\UserController@upload');
//基本信息修改
Route::post('user/basic', 'Index\UserController@basic');
//我的发帖
Route::get('user/article', 'Index\UserController@index');
Route::post('user/article', 'Index\UserController@index');
//我的发帖下一页(API)
Route::get('user/indexToMy', 'Index\UserController@indexByMyToAPI');

//我的收藏
Route::get('user/collection', 'Index\UserController@collection');
Route::post('user/collection', 'Index\UserController@collection');
//我的收藏下一页(API)
Route::get('user/indexToCollection', 'Index\UserController@indexByCollectionToAPI');

//我的消息
Route::get('user/message', 'Index\UserController@message');
//删除消息
Route::get('user/deleteMessage/{message_id}', 'Index\UserController@deleteMessage');
//清除所有消息
Route::get('user/clearMessage', 'Index\UserController@clearMessage');

//上传
Route::post('publish/upload', 'Index\PublishController@upload');

//邮箱辅助登录
Route::get('check/{token}', 'Index\LoginController@check');

//帖子展示
Route::get('article/detail/{id}', 'Index\ArticleController@detail')
    ->middleware('read');

//帖子的修改编辑
Route::get('article/edit/{article_id}', 'Index\ArticleController@edit');

//帖子的修改提交
Route::post('article/edit/{article_id}', 'Index\ArticleController@edit');

//帖子的收藏(需要用户登录态)
Route::get('article/collection/{article_id}', 'Index\ArticleController@collection');

//评论
Route::post('comment/add', 'Index\ArticleController@comment');

//评论删除
Route::get('comment/del/{comment_id}', 'Index\ArticleController@del_comment');

//采纳
Route::get('comment/accept/{comment_id}/{article_id}', 'Index\ArticleController@accept');

//文章置顶
Route::get('article/top/{article_id}', 'Index\ArticleController@top');

//文章精华
Route::get('article/essence/{article_id}', 'Index\ArticleController@essence');

//签到
Route::get('user/sign', 'Index\SignController@todaySign');

//检索
Route::any('article/search', 'Index\ArticleController@search');



/**聊天室界面**/
//聊天室列表
Route::get('chat', 'Index\ChatController@index');

//聊天室
Route::get('chat/room', 'Index\ChatController@room');

