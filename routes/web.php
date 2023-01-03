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

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/register', '\App\Http\Controllers\RegisterController@index');
Route::post('/register', '\App\Http\Controllers\RegisterController@register');
//Route::get('/aaa', '\App\Http\Controllers\LoginController@aaa');
Route::get('/login', '\App\Http\Controllers\LoginController@index');
Route::post('/login', '\App\Http\Controllers\LoginController@login');
Route::get('/logout', '\App\Http\Controllers\LoginController@logout');
Route::get('/user/me/setting', '\App\Http\Controllers\UserController@setting');
Route::post('/user/me/setting', '\App\Http\Controllers\UserController@settingStore');
Route::post('/user/avatar/upload', '\App\Http\Controllers\UserController@avatarUpload');
Route::get('/user/{user}', '\App\Http\Controllers\UserController@show');
Route::post('/user/{user}/fan', '\App\Http\Controllers\UserController@fan');
Route::post('/user/{user}/unfan', '\App\Http\Controllers\UserController@unfan');

//Route::get('/user/setting', '\App\Http\Controllers\UserController@setting');
//Route::post('/user/setting', '\App\Http\Controllers\UserController@settingStore');

Route::group(['middleware' => 'auth:web'], function() {
    Route::get('/posts', '\App\Http\Controllers\PostController@index');
    Route::get('/posts/create', '\App\Http\Controllers\PostController@create');
    Route::get('/posts/search', '\App\Http\Controllers\PostController@search');
    Route::get('/posts/{post}', '\App\Http\Controllers\PostController@show');
    Route::post('/posts/store', '\App\Http\Controllers\PostController@store');
    Route::get('/posts/{post}/edit', '\App\Http\Controllers\PostController@edit');
    Route::put('/posts/{post}/update', '\App\Http\Controllers\PostController@update');
    Route::get('/posts/{post}/delete', '\App\Http\Controllers\PostController@delete');
    Route::post('/posts/image/upload', '\App\Http\Controllers\PostController@imageUpload');

    Route::post('/posts/{post}/comment', '\App\Http\Controllers\PostController@comment');
    Route::get('/comment/{comment}/delete', '\App\Http\Controllers\PostController@commentDelete');

    Route::get('/posts/{post}/like', '\App\Http\Controllers\PostController@like');
    Route::get('/posts/{post}/unlike', '\App\Http\Controllers\PostController@unlike');

    Route::get('/topic/{topic_id}', '\App\Http\Controllers\TopicController@show');
    Route::get('/topic/{topic}/submit', '\App\Http\Controllers\TopicController@submit');

    Route::get('/notices', '\App\Http\Controllers\NoticeController@index');
});

include_once('admin.php');


