<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;

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

Route::get('/posts/{comment?}', function($comment = null){
    return view('comment', ['comment'=>$comment]);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/comments', [CommentController::class, 'index'])
    ->name('comments.index');
Route::get('/comments/create', [CommentController::class, 'create'])
    ->name('comments.create');
Route::post('/comments', [CommentController::class, 'store'])
    ->name('comments.store');
Route::get('/comments/{id}', [CommentController::class, 'show'])
    ->name('comments.show');

require __DIR__.'/auth.php';
