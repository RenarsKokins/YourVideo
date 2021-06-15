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

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/get_recommended', [App\Http\Controllers\HomeController::class, 'get_recommended'])->name('home.get_recommended');

Route::get('/account/upload', [App\Http\Controllers\AccountController::class, 'show_upload'])->name('account.upload')->middleware(['auth']);
Route::post('/account/upload', [App\Http\Controllers\AccountController::class, 'store_video'])->name('account.upload')->middleware(['auth']);
Route::get('/account/view', [App\Http\Controllers\AccountController::class, 'show_view'])->name('account.view_videos')->middleware(['auth']);
Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account')->middleware(['auth']);

Route::get('/video', [App\Http\Controllers\VideoViewController::class, 'showVideo'])->name('video.view');
Route::post('/video/like', [App\Http\Controllers\VideoViewController::class, 'saveLike'])->name('video.like');
Route::post('/video/comment', [App\Http\Controllers\VideoViewController::class, 'saveComment'])->name('video.comment');
Route::post('/video/get_comment', [App\Http\Controllers\VideoViewController::class, 'getComment'])->name('video.get_comment');

Route::post('/follow', [App\Http\Controllers\FollowController::class, 'followingLogic'])->name('follow');

Route::get('/search', [App\Http\Controllers\SearchController::class, 'show'])->name('search');

