<?php

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

Route::get('/',"PageController@index");


Route::get('/about', function () {
    return view('pages.about');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('posts','PostController');

Route::resource('files','FileController');

Route::resource('users','UserController');

//Cms
Route::get('cms/post',"CmsController@post");

Route::get('cms/file',"CmsController@file");

Route::get('cms/usermanagment',"CmsController@usermanagment");
