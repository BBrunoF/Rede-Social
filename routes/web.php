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

Route::get('/', function () {
    return redirect(route('home'));
});

// Temporary fix for unknown bug.
Route::get('/favicon.ico', function () {
    return redirect(route('home'));
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('/home', function () {
        return view('home');
    })->name('home');

    Route::resource('/posts', "App\Http\Controllers\PostController")->names('posts');
    Route::get('/feeds', "App\Http\Controllers\PostController@followers")->name('feeds');
    Route::resource('/manage/users', "App\Http\Controllers\UserController")->except(['create', 'show', 'store'])->names('users');
    Route::get('/manage/reports', "App\Http\Controllers\UserController@showReports")->name('reports');
    Route::get('/post/{location}', "App\Http\Controllers\PostController@show")->name('map');
    
    Route::middleware(['auth'])->group(function () {
        Route::get('/messages', "App\Http\Controllers\MessageController@index")->name('messages.index');
        Route::get('/messages/{chatId}', "App\Http\Controllers\MessageController@show")->name('messages.show');
        Route::post('/messages/chat/{authUserId}/{otherUser}', "App\Http\Controllers\MessageController@createChat")->name('messages.createChat');
        Route::post('/messages/{chatId}', "App\Http\Controllers\MessageController@send")->name('messages.send');
        Route::get('/messages/chats', "App\Http\Controllers\MessageController@showChats")->name('messages.showChats');
      });
    
    Route::get('/{username}', "App\Http\Controllers\ProfileController@show")->name('profile');
});
