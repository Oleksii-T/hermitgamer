<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
 *
 * Routes for client side
 *
 */

Route::any('dev/{action}', [\App\Http\Controllers\DevController::class, 'action']);

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('more', [PostController::class, 'more']);
});

Route::prefix('comments')->name('comments.')->group(function () {
    Route::post('/', [CommentController::class, 'store'])->name('store');
    Route::post('/like', [CommentController::class, 'like'])->name('like');
});

Route::get('/', [PageController::class, 'index'])->name('index');

Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');

Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

Route::get('tags/{tag}', [TagController::class, 'show'])->name('tags.show');

Route::get('games/{game}', [GameController::class, 'show'])->name('games.show');

