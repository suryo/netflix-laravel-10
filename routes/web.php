<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\MovieController as AdminMovieController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\CommentController;


use App\Http\Controllers\Admin\TvChannelController as AdminTvChannelController;
use App\Http\Controllers\TvController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
Route::get('/tv-series', [MovieController::class, 'tvSeries'])->name('tv.index');
Route::get('/movies/{slug}', [MovieController::class, 'show'])->name('movies.show');
Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/category/{slug}', [MovieController::class, 'byCategory'])->name('movies.category');
Route::get('/21-plus', [MovieController::class, 'adultIndex'])->name('movies.adult');

// TV Online Routes
Route::get('/tv-online', [TvController::class, 'index'])->name('tv_online.index');
Route::get('/tv-online/{slug}', [TvController::class, 'show'])->name('tv_online.show');

// Auth Routes
Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [\App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('movies', AdminMovieController::class)->except(['show']);
    Route::resource('comments', AdminCommentController::class)->only(['index', 'destroy']);
    Route::resource('tv-channels', AdminTvChannelController::class)->except(['show']);
    Route::get('users/approvals', [\App\Http\Controllers\Admin\DashboardController::class, 'approvals'])->name('users.approvals');
    Route::post('users/{user}/approve-member', [\App\Http\Controllers\Admin\DashboardController::class, 'approveMember'])->name('users.approve_member');
    Route::post('users/{user}/approve-adult', [\App\Http\Controllers\Admin\DashboardController::class, 'approveAdult'])->name('users.approve_adult');

    // Impersonation Routes
    Route::post('users/{user}/impersonate', [\App\Http\Controllers\Admin\ImpersonationController::class, 'impersonate'])->name('users.impersonate');
});

// Stop Impersonation (needs to be accessible when logged in as member)
Route::match(['get', 'post'], '/admin/stop-impersonating', [\App\Http\Controllers\Admin\ImpersonationController::class, 'stop'])->name('admin.stop_impersonating')->middleware('auth');
