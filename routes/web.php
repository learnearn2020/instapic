<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
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
use App\Image;

Auth::routes();

// Users routes
Route::get('/', 'HomeController@index')->name('home');
Route::get('/config', 'userController@config')->name('config');
Route::get('/users/{search?}', 'userController@index')->name('user.index');
Route::post('/update', 'userController@update')->name('user.update');
Route::get('/avatar/{image_path}', 'userController@getImage')->name('user.avatar');
Route::get('/perfil/{id}', 'userController@perfil')->name('user.perfil');
Route::get('/news', 'userController@news')->name('user.news');


// route for shared pictures
Route::get('share', 'shareController@create')->name('share.create');
Route::post('share/save', 'shareController@save')->name('share.save');
Route::get('/share/avatar/{image_path}', 'shareController@getImage')->name('share.avatar');
Route::get('/share/detail/{id}', 'shareController@detail')->name('share.detail');

// comments routes
Route::post('comment/save', 'commentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'commentController@delete')->name('comment.delete');

// likes routes
Route::get('/like/{image_id}', 'likeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'likeController@dislike')->name('like.delete');
Route::get('/image/delete/{id}', 'shareController@delete')->name('image.delete');
Route::get('/image/edit/{id}', 'shareController@edit')->name('image.edit');
Route::post('image/update', 'shareController@update')->name('image.update');
Route::get('/likes', 'likeController@index')->name('like.index');
