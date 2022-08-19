<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GameController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AttachmentController;

/*
 *
 * Routes for admin panel
 *
 */

Route::view('/login', 'admin.auth.login')->name('login');

Route::middleware('is-admin')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('index');

    Route::resource('users', UserController::class)->except('show');

    Route::resource('categories', CategoryController::class)->except('show');

    Route::resource('tags', TagController::class)->except('show');

    Route::resource('games', GameController::class)->except('show');

    Route::resource('authors', AuthorController::class)->except('show');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('{post}/edit-content', [PostController::class, 'editContent'])->name('edit-content');
        Route::post('{post}/update-content', [PostController::class, 'updateContent'])->name('update-content');
    });
    Route::resource('posts', PostController::class)->except('show');

    Route::resource('comments', CommentController::class)->except('show');

    Route::resource('settings', SettingController::class)->except('show');

    Route::get('pages/{page}/edit-blocks', [PageController::class, 'editBlocks'])->name('pages.edit-blocks');
    Route::put('pages/{page}/update-blocks', [PageController::class, 'updateBlocks'])->name('pages.update-blocks');
    Route::resource('pages', PageController::class)->except('show');

    Route::prefix('attachments')->name('attachments.')->group(function () {
        Route::get('{attachment}/download', [AttachmentController::class, 'download'])->name('download');
    });
    Route::resource('attachments', AttachmentController::class)->except('create', 'store', 'show');
});
