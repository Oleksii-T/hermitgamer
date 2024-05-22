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

foreach (\App\Models\Redirect::getAll() as $r) {
    Route::get("{$r->from}", function () use ($r) {
        if (request()->getQueryString()) {
            $r->to .= '?'.request()->getQueryString();
        }

        $r->update([
            'last_at' => now(),
            'hits' => $r->hits+1
        ]);

        return redirect("$r->to", $r->code);
    });
}

Route::prefix('posts')->name('posts.')->group(function () {
    Route::post('{post}/view', [PostController::class, 'view'])->name('view');
    Route::get('more', [PostController::class, 'more']);
});

Route::get('/', [PageController::class, 'index'])->name('index');
Route::get('search', [PageController::class, 'search'])->name('search');
Route::get('how-we-review', [PageController::class, 'rate'])->name('rate');
Route::get('contact', [PageController::class, 'contactUs'])->name('contact-us');
Route::post('contact-us', [PageController::class, 'contactUs'])->name('feedbacks.store')->middleware('recaptcha');
Route::get('about', [PageController::class, 'aboutUs'])->name('about-us');
Route::get('privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('terms-of-service', [PageController::class, 'terms'])->name('terms');
Route::get('{page}', [PageController::class, 'show'])->where('page', \App\Models\Page::getAllSlugs());


Route::get('{category}', [CategoryController::class, 'show'])->name('categories.show')->where('category', \App\Models\Category::getAllSlugs());

Route::get('{author}', [AuthorController::class, 'show'])->name('authors.show')->where('author', \App\Models\Author::getAllSlugs());

// Route::get('{tag}', [TagController::class, 'show'])->name('tags.show')->where('tag', \App\Models\Tag::getAllSlugs());

Route::get('{game}', [GameController::class, 'show'])->name('games.show')->where('game', \App\Models\Game::getAllSlugs());

Route::get('{post}', [PostController::class, 'show'])->name('posts.show')->where('post', \App\Models\Post::getAllSlugs());