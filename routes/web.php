<?php

use App\Http\Controllers\{
PostController
};
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
Route::middleware(['auth'])->group(function() {
    Route::any('/posts/search',  [PostController::class, 'search'])->name('posts.search');
    Route::put('/posts/{id}' , [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/edit{id}', [PostController::class, 'edit'])->name('posts.edit');
    route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/create',[PostController::class, 'create'])->name('posts.create');
    Route::get('/posts/show/{id}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts',[PostController::class, 'index'])->name('posts.index')->middleware(['auth']);
});


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';