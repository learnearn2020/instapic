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
/*
Route::get('/try', function () {
    $imges=Image::all();
    foreach($imges as $image){
        
        echo $image->image_path. ' - ' . $image->description. ' - '.$image->user->name.  '<br>';
        echo 'Comments : ';
        if(count($image->comments)>=1){
            echo '<div style=" color:white; background-color:black;padding:10px;border-radius:2px;width:300px;">';
            foreach($image->comments as $comment){
               
                echo $comment->user->name . ' ' .  $comment->user->surname . '  says :  '.   $comment->content. '<br>';
               
            }
            echo '</div>';
        }else{
            echo '<div style=" color:white; background-color:red;padding:10px;border-radius:2px;width:300px;">';

             echo 'No comment por ahora';
            echo '</div>';

        }
        echo '<div style="width:20px;height:20px;border-radius:50%; background-color:red;color:black; text-align:center;padding:5px;margin:5px;" >';
            echo count($image->likes);

        echo '</div>';
        
        echo '<hr>';
        
    }

    die();
    return view('welcome');
});
*/
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




