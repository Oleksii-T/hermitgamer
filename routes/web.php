<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthorController;
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
    Route::post('{post}/view', [PostController::class, 'view'])->name('view');
    Route::get('more', [PostController::class, 'more']);
});

Route::prefix('comments')->name('comments.')->group(function () {
    Route::post('/', [CommentController::class, 'store'])->name('store');
    Route::post('/like', [CommentController::class, 'like'])->name('like');
});

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('search', [PageController::class, 'search'])->name('search');
Route::get('rate', [PageController::class, 'rate'])->name('rate');
Route::get('contact-us', [PageController::class, 'contactUs'])->name('contact-us');
Route::post('contact-us', [PageController::class, 'contactUs'])->name('feedbacks.store')->middleware('recaptcha');
Route::get('about-us', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('terms', [PageController::class, 'terms'])->name('terms');

Route::get('{category}', [CategoryController::class, 'show'])->name('categories.show')->where('category', \App\Models\Category::getAllSlugs());

Route::get('{author}', [AuthorController::class, 'show'])->name('authors.show')->where('author', \App\Models\Author::getAllSlugs());

Route::get('{tag}', [TagController::class, 'show'])->name('tags.show')->where('tag', \App\Models\Tag::getAllSlugs());

Route::get('{game}', [GameController::class, 'show'])->name('games.show')->where('game', \App\Models\Game::getAllSlugs());

Route::get('{post}', [PostController::class, 'show'])->name('posts.show')->where('post', \App\Models\Post::getAllSlugs());