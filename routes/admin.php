<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\FeedbackController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\FeedbackBanController;

/*
 *
 * Routes for admin panel
 *
 */

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('admin.index');
    }
    return view('admin.auth.login');
})->name('login');

Route::middleware('is-admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('users', UserController::class)->except('show');

    Route::resource('categories', CategoryController::class)->except('show');

    Route::resource('tags', TagController::class)->except('show');

    Route::resource('games', GameController::class)->except('show');

    Route::prefix('authors')->name('authors.')->group(function () {
        Route::get('{author}/edit/socials', [AuthorController::class, 'socials'])->name('socials');
        Route::get('{author}/edit/boocks', [AuthorController::class, 'blocks'])->name('blocks');
        Route::put('{author}/edit/socials', [AuthorController::class, 'updateSocials'])->name('update-socials');
        Route::post('{author}/edit/blocks', [AuthorController::class, 'updateBlocks'])->name('update-blocks');
    });
    Route::resource('authors', AuthorController::class)->except('show');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('{post}/blocks', [PostController::class, 'blocks'])->name('blocks');
        Route::get('{post}/faqs', [PostController::class, 'faqs'])->name('faqs');
        Route::get('{post}/assets', [PostController::class, 'assets'])->name('assets');
        Route::get('{post}/related', [PostController::class, 'related'])->name('related');
        Route::get('{post}/conclusion', [PostController::class, 'conclusion'])->name('conclusion');
        Route::put('{post}/conclusion', [PostController::class, 'updateConclusion'])->name('update-conclusion');
        Route::get('{post}/reviewsFields', [PostController::class, 'reviewsFields'])->name('reviewsFields');
        Route::post('{post}/blocks', [PostController::class, 'updateBlocks'])->name('update-blocks');
        Route::post('{post}/faqs', [PostController::class, 'storeFaq'])->name('store-faq');
        Route::get('{id}/recover', [PostController::class, 'recover'])->name('recover');
        Route::put('{post}/assets', [PostController::class, 'updateAssets'])->name('update-assets');
        Route::put('{post}/reviewsFields', [PostController::class, 'updateReviewsFields'])->name('update-reviewsFields');
        Route::put('{post}/related', [PostController::class, 'updateRelated'])->name('update-related');
        Route::put('{post}/faqs/{faq}', [PostController::class, 'updateFaq'])->name('update-faq');
        Route::delete('{post}/faqs/{faq}', [PostController::class, 'destroyFaq'])->name('destroy-faq');
    });
    Route::resource('posts', PostController::class)->except('show');

    Route::resource('comments', CommentController::class)->except('show');

    Route::resource('settings', SettingController::class)->except('show');

    Route::post('feedback-bans/{feedback-ban}/toggle', [FeedbackBanController::class, 'toggle'])->name('feedback-bans.toggle');
    Route::resource('feedback-bans', FeedbackBanController::class)->only('index', 'store', 'update', 'destroy');

    Route::resource('feedbacks', FeedbackController::class)->only('show', 'index', 'destroy', 'update');

    Route::get('pages/{page}/edit-blocks', [PageController::class, 'editBlocks'])->name('pages.edit-blocks');
    Route::put('pages/{page}/update-blocks', [PageController::class, 'updateBlocks'])->name('pages.update-blocks');
    Route::resource('pages', PageController::class)->except('show');

    Route::prefix('attachments')->name('attachments.')->group(function () {
        Route::post('upload', [AttachmentController::class, 'upload'])->name('upload');
        Route::get('{attachment}/download', [AttachmentController::class, 'download'])->name('download');
    });
    Route::resource('attachments', AttachmentController::class)->except('create', 'store', 'show');
});
