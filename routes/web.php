<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CommentController;

/*
 *
 * Routes for client side
 *
 */

Route::get('/', [PageController::class, 'index'])->name('index');

Route::prefix('post')->name('posts.')->group(function () {

    Route::get('{post:slug}', [PostController::class, 'index'])->name('show');

});

Route::prefix('categories')->name('categories.')->group(function () {
    Route::get('{category:slug}', [CategoryController::class, 'index'])->name('show');
});

Route::prefix('tags')->name('tags.')->group(function () {
    Route::get('{tag:slug}', [TagController::class, 'index'])->name('show');
});

Route::prefix('games')->name('games.')->group(function () {
    Route::get('{game:slug}', [GameController::class, 'index'])->name('show');
});

Route::prefix('comments')->name('comments.')->group(function () {
    Route::post('/', [CommentController::class, 'store'])->name('store');
    Route::post('/like', [CommentController::class, 'like'])->name('like');
});

