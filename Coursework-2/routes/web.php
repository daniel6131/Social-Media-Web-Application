<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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
    return view('welcome');
});

Route::get('/show/{id}', [UserController::class, 'show'])
    ->name('user.show');

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::post('/createpost', [PostController::class, 'create'])
    ->middleware(['auth'])->name('post.create');

Route::get('/destroy-post/{id}', [PostController::class, 'destroy'])
    ->middleware(['auth'])->name('post.destroy');

Route::post('/postupdate' ,[PostController::class, 'update'])
    ->name('post.update');

Route::get('/show-post/{id}', [PostController::class, 'show'])
    ->middleware(['auth'])->name('post.show');

Route::get('/followuser/{id}', [UserController::class, 'follow'])
    ->middleware(['auth'])->name('user.follow');

Route::get('/unfollowuser/{id}', [UserController::class, 'unfollow'])
    ->middleware(['auth'])->name('user.unfollow');

Route::get('/user/create', [UserController::class, 'create'])
    ->middleware(['auth'])->name('user.create');

Route::post('/dashboard', [UserController::class, 'store'])
    ->middleware(['auth'])->name('user.store');

Route::get('/postmedia/{mediaPath}', [PostController::class, 'getPostMedia'])
    ->name('post.media');

Route::post('/commentupdate', [PostController::class, 'updateComment'])
    ->name('comments.update');

Route::post('/commentdestory', [PostController::class, 'destroyComment'])
    ->name('comments.destroy');

require __DIR__.'/auth.php';
