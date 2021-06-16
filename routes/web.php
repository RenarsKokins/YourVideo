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
Route::post('/get_following', [App\Http\Controllers\HomeController::class, 'get_following'])->name('home.get_following');

Route::get('/account/upload', [App\Http\Controllers\AccountController::class, 'show_upload'])->name('account.upload')->middleware(['auth']);
Route::post('/account/upload', [App\Http\Controllers\AccountController::class, 'store_video'])->name('account.upload')->middleware(['auth']);

Route::get('/account/myvideos', [App\Http\Controllers\AccountController::class, 'show_view'])->name('account.view_videos')->middleware(['auth']);
Route::post('/account/myvideos/view', [App\Http\Controllers\AccountController::class, 'get_videos'])->name('account.view_videos.view')->middleware(['auth']);

Route::get('/account/allvideos', [App\Http\Controllers\AccountController::class, 'show_view'])->name('account.view_videos_admin')->middleware(['auth']);
Route::post('/account/allvideos/view', [App\Http\Controllers\AccountController::class, 'get_videos_admin'])->name('account.view_videos_admin.view')->middleware(['auth']);

Route::post('/account/myvideos/delete', [App\Http\Controllers\AccountController::class, 'delete_video'])->name('account.view_videos.delete')->middleware(['auth']);

Route::get('/account/myvideos/modify/{id}', [App\Http\Controllers\AccountController::class, 'show_modify'])->name('account.show_modify')->middleware(['auth']);
Route::post('/account/myvideos/modify/save', [App\Http\Controllers\AccountController::class, 'modify_video'])->name('account.modify')->middleware(['auth']);

Route::get('/account', [App\Http\Controllers\AccountController::class, 'index'])->name('account')->middleware(['auth']);

Route::get('/video', [App\Http\Controllers\VideoViewController::class, 'showVideo'])->name('video.view');
Route::post('/video/like', [App\Http\Controllers\VideoViewController::class, 'saveLike'])->name('video.like');
Route::post('/video/comment', [App\Http\Controllers\VideoViewController::class, 'saveComment'])->name('video.comment');
Route::post('/video/get_comment', [App\Http\Controllers\VideoViewController::class, 'getComment'])->name('video.get_comment');

Route::post('/follow', [App\Http\Controllers\FollowController::class, 'followLogic'])->name('follow');
Route::post('/follow/check', [App\Http\Controllers\FollowController::class, 'checkFollow'])->name('follow.check');
Route::post('/follow/get', [App\Http\Controllers\FollowController::class, 'getFollows'])->name('follow.get');

Route::post('/search', [App\Http\Controllers\SearchController::class, 'show'])->name('search');
Route::post('/search/view', [App\Http\Controllers\SearchController::class, 'get_videos'])->name('search.view');

