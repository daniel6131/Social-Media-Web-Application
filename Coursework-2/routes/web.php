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

Route::get('/profile', [UserController::class, 'show'])
    ->name('user.profile');

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::post('/createpost', [PostController::class, 'create'])
    ->middleware(['auth'])->name('post.create');

Route::get('/destroy-post/{id}', [PostController::class, 'destroy'])
    ->middleware(['auth'])->name('post.destroy');

Route::post('/update' ,[PostController::class, 'update'])
    ->name('post.update');

Route::get('/show-post/{id}', [PostController::class, 'show'])
    ->middleware(['auth'])->name('post.show');

require __DIR__.'/auth.php';
