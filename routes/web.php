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
| routes/web.php は HTTPリクエストのすべての入り口。
| Routerの具体的な設定コードは routes/web.php にあり、ここにすべてのルーティングが書かれる。
*/

/*
Route::get('/', 'TasksController@index');
Route::resource('tasks', 'TasksController');
*/


// デフォルトトップページへのルーティング
Route::get('/', function () {
    return view('welcome');
});

// for Lesson15
// Route::get('/', 'TasksController@index');

// ユーザ登録(Auth内のRegisterControllerが担当)
Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');

// 認証(Auth内のLoginControllerが担当)
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');

// 認証付きのルーティング。認証済みのユーザだけが登録・削除のアクションにアクセスできる
Route::group(['middleware' => ['auth']], function () {
    Route::resource('tasks', 'TasksController', ['only' => ['store', 'destroy']]);
});
