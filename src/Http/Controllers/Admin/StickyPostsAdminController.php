<?php

/**
 * Sticky Posts — Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\StickyPosts\Http\Controllers\Admin;

use Contensio\Models\Content;
use Contensio\Plugins\StickyPosts\Support\StickyHelper;
use Illuminate\Routing\Controller;

class StickyPostsAdminController extends Controller
{
    /**
     * List all published posts with their sticky status.
     */
    public function index()
    {
        $items = Content::with(['defaultTranslation', 'contentType'])
            ->where('status', Content::STATUS_PUBLISHED)
            ->orderByDesc('published_at')
            ->get()
            ->map(function (Content $content) {
                return [
                    'id'        => $content->id,
                    'title'     => $content->defaultTranslation?->title ?? '(Untitled)',
                    'type'      => $content->contentType?->name ?? 'Content',
                    'published' => $content->published_at,
                    'sticky'    => StickyHelper::isSticky($content->id),
                ];
            });

        return view('sticky-posts::admin.index', compact('items'));
    }

    /**
     * Pin a post.
     */
    public function pin(int $contentId)
    {
        StickyHelper::setSticky($contentId, true);
        return back()->with('success', 'Post pinned to the top.');
    }

    /**
     * Unpin a post.
     */
    public function unpin(int $contentId)
    {
        StickyHelper::setSticky($contentId, false);
        return back()->with('success', 'Post unpinned.');
    }
}
