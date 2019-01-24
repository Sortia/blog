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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', 'MainController@getMainPage');

Route::get('/post', function () {
    return view('post');
});

Route::get('/category/{category}', 'MainController@getPostsByCategory');

Route::get('/search', 'MainController@searchPosts');

Route::post('/post/{id}', 'MainController@addComment');


Route::get('/post/{id}', 'MainController@getPost');

Route::post('/delete_post/{id}', 'MainController@deletePost')->middleware('checkRole');
Route::post('/delete_comment/{id}', 'MainController@deleteComment')->middleware('checkRole');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/add_post', 'MainController@add_post');

Route::post('/add_post', 'MainController@save_new_post');
Route::post('/add_post_image/{post_id}', 'MainController@save_new_post_image');
