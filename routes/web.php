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

// 首页路由
Route::get('/', 'Portal\HomeController@root')->name('root');
// 测试路由
Route::resource('tests', 'TestsController');

/**
 * 用户相关路由
 * Auth::routes();
 * 等同于以下路由
 * 可以在 vendor/laravel/framework/src/Illuminate/Routing/Router.php 中搜索关键词 LoginController 即可找到定义的地方
 */
// 『用户身份验证相关的路由』
// 直接返回 「auth.login」 视图
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// 用户登录信息逻辑处理
Route::post('login', 'Auth\LoginController@login');
// 用户登出信息逻辑处理
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// 『用户注册相关路由』
// 直接返回 「auth.register」 视图
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
// 用户注册信息逻辑处理
Route::post('register', 'Auth\RegisterController@register');

// 『密码重置相关路由』
// 1、直接返回 「auth.passwords.email」 视图
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
// 2、点击 「发送重置密码链接」 按钮，发送重置 URL 到指定邮箱，再次返回 「auth.passwords.email」 视图，并给与发送成功提示
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
// 3、直接返回 「auth.passwords.reset」 视图，并附带重置 Token 和需要重置的 Email
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
// 4、用户重置密码信息逻辑处理
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// 『密码重置相关路由』
// 1、提示 「需要验证 Email」 界面，返回 「auth.verify」 视图
Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
// 2、点击 「重新发送 Email」 按钮，发送验证邮箱的邮件到指定邮箱，再次返回 「auth.verify」 视图，并给与发送成功提示
Route::post('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
// 3、点击 「验证 Email」 按钮，验证邮箱（在指定邮箱中可见此按钮），返回认证前的当前页面
Route::get('email/verify/{id}/{hash}', 'Auth\VerificationController@verify')->name('verification.verify');

// 『用户相关路由』
Route::get('/users/{user}', 'Auth\UsersController@show')->name('users.show');  // 显示用户个人信息页面


Route::group(
    [
        'middleware' => ['auth']
    ],
    function () {
        Route::resource('users', 'Auth\UsersController', ['only' => ['update', 'edit']]);
        // Route::get('/users/{user}/edit', 'Auth\UsersController@edit')->name('users.edit');    // 显示编辑个人资料页面
        // Route::patch('/users/{user}', 'Auth\UsersController@update')->name('users.update');   // 处理 edit 页面提交的更改
        // 需要登录之后才允许操作的文章类方法
        Route::resource('articles', 'Portal\Article\ArticlesController', ['except' => ['index', 'show']]);
        // Simditor html 编辑器图片上传
        Route::post('upload_image', 'Portal\Article\ArticlesController@uploadImage')->name('articles.upload_image');
        // 文章回复
        Route::resource('replies', 'Portal\Article\RepliesController', ['only' => ['store', 'destroy']]);
        // 评论通知列表
        Route::get('notifications', 'Portal\Article\NotificationsController@index')->name('notifications.index');
    });

// 不需要登录就可以访问的文章类方法
Route::get('/articles', 'Portal\Article\ArticlesController@index')->name('articles.index');
Route::get('/articles/{article}/{slug?}', 'Portal\Article\ArticlesController@show')->name('articles.show');

Route::get('/categories/{category}', 'Portal\Article\CategoriesController@show')->name('categories.show');
