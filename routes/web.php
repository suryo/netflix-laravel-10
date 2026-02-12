<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\CommentController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/movies/{slug}', [MovieController::class, 'show'])->name('movies.show');
Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])->name('comments.store');


Route::get('/category/{slug}', [MovieController::class, 'byCategory'])->name('movies.category');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('movies', AdminMovieController::class)->except(['show']);
    Route::resource('comments', AdminCommentController::class)->only(['index', 'destroy']);
});
