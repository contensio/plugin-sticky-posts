<?php

/**
 * Sticky Posts — Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\StickyPosts;

use Contensio\Plugins\StickyPosts\Support\StickyHelper;
use Contensio\Support\Hook;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class StickyPostsServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'sticky-posts');

        $this->registerRoutes();

        Hook::add('contensio/admin/settings-cards', function (): string {
            return view('sticky-posts::partials.settings-hub-card')->render();
        });

        // Dashboard quick-action badge — shows the count of pinned posts
        Hook::add('contensio/admin/dashboard-quick-actions', function (): string {
            try {
                $count = count(StickyHelper::stickyIds());
            } catch (\Throwable) {
                return '';
            }
            if ($count === 0) {
                return '';
            }
            return '<span class="inline-flex items-center gap-1.5 border border-amber-300 bg-amber-50 text-amber-700 text-xs font-semibold px-3 py-1.5 rounded-lg">'
                . '<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>'
                . $count . ' pinned</span>';
        });
    }

    private function registerRoutes(): void
    {
        if (! $this->app->routesAreCached()) {
            Route::middleware('web')
                ->group(__DIR__ . '/../routes/web.php');
        }
    }
}
