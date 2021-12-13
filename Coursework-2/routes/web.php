<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::get('/dashboard', [PostController::class, 'index'])
    ->middleware(['auth'])->name('dashboard');

Route::post('/createpost', [PostController::class, 'create'])
    ->middleware(['auth'])->name('post.create');

Route::get('/destroy-post/{id}', [PostController::class, 'destroy'])
    ->middleware(['auth'])->name('post.destroy');

require __DIR__.'/auth.php';
