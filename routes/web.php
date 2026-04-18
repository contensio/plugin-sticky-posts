<?php

use Contensio\Plugins\StickyPosts\Http\Controllers\Admin\StickyPostsAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'contensio.admin'])
    ->prefix('account/settings')
    ->group(function () {
        Route::get('sticky-posts', [StickyPostsAdminController::class, 'index'])
            ->name('sticky-posts.index');

        Route::post('sticky-posts/{contentId}/pin', [StickyPostsAdminController::class, 'pin'])
            ->name('sticky-posts.pin');

        Route::post('sticky-posts/{contentId}/unpin', [StickyPostsAdminController::class, 'unpin'])
            ->name('sticky-posts.unpin');
    });
