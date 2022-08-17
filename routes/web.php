<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
 *
 * Routes for client side
 *
 */

Route::prefix('posts')->name('posts.')->group(function () {
    Route::get('more', [PostController::class, 'more']);
});

Route::prefix('comments')->name('comments.')->group(function () {
    Route::post('/', [CommentController::class, 'store'])->name('store');
    Route::post('/like', [CommentController::class, 'like'])->name('like');
});

Route::middleware(['localize', 'localeSessionRedirect', 'localizationRedirect'])->prefix(LaravelLocalization::setLocale())->group(function () {
    Route::get('/', [PageController::class, 'index'])->name('index');

    Route::get(LaravelLocalization::transRoute('routes.posts.show'), [PostController::class, 'show'])->name('posts.show');

    Route::get(LaravelLocalization::transRoute('routes.categories.show'), [CategoryController::class, 'show'])->name('categories.show');

    Route::get(LaravelLocalization::transRoute('routes.tags.show'), [TagController::class, 'show'])->name('tags.show');

    Route::get(LaravelLocalization::transRoute('routes.games.show'), [GameController::class, 'show'])->name('games.show');
});

