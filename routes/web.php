<?php

use Contensio\Plugins\StickyPosts\Http\Controllers\Admin\StickyPostsAdminController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'contensio.admin'])
    ->prefix('account/settings')
    ->group(function () {
        Route::get('sticky-posts', [StickyPostsAdminController::class, 'index'])
            ->name('contensio-sticky-posts.index');

        Route::post('sticky-posts/{contentId}/pin', [StickyPostsAdminController::class, 'pin'])
            ->name('contensio-sticky-posts.pin');

        Route::post('sticky-posts/{contentId}/unpin', [StickyPostsAdminController::class, 'unpin'])
            ->name('contensio-sticky-posts.unpin');
    });
