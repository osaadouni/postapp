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

Route::get('/', function () {
    return view('posts.index');
});

Route::post('favorite/{post}', 'PostController@favoritePost');
Route::post('unfavorite/{post}', 'PostController@unFavoritePost');

Route::get('my_favorites', 'UsersController@myFavorites')->middleware('auth');

Route::resource('posts', 'PostController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/favorite', 'UsersController@index')->middleware('auth');
