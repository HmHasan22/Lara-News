<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Auth::routes();
Route::get('/', [NewsController::class,'index'])->name('news.index');
//news
Route::controller(NewsController::class)->prefix('news')->group(function () {
    Route::get('/add', 'add')->name('news.add');
    Route::post('/store', 'store')->name('news.store');
    Route::get('/{slug}', 'show')->name('news.show');
    Route::get('/{id}/edit', 'edit')->name('news.edit');
    Route::put('/{id}/update', 'update')->name('news.update');
    Route::delete('/{id}/delete', 'destroy')->name('news.destroy');
});

//comment route

Route::controller(CommentController::class)->prefix('comment')->group(function () {
    Route::post('/store', 'store')->name('comment.store');
    Route::post('/delete','destroy')->name('comment.delete');
});

//category route
Route::controller(CategoryController::class)->prefix('category')->group(function () {
    Route::get('/', 'index')->name('category.index');
    Route::get('/{slug}', 'show')->name('categories.news');
});
