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

Route::get('/', function () { return view('login');})->name('login.view');
Route::get('register', function () { return view('register');})->name('register.view');
Route::post('login','UserController@login')->name('login');
Route::get('logout','UserController@logout')->name('logout');
Route::post('register','UserController@store')->name('register');
Route::post('post','PostController@store')->name('post');
Route::get('board','PostController@index')->name('board');
Route::post('comment','CommentController@store')->name('comment');