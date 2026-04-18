<?php

/**
 * Sticky Posts — Contensio plugin.
 * https://contensio.com
 *
 * @copyright   Copyright (c) 2026 Iosif Gabriel Chimilevschi
 * @license     https://www.gnu.org/licenses/agpl-3.0.txt  AGPL-3.0-or-later
 */

namespace Contensio\Plugins\StickyPosts\Support;

use Contensio\Models\ContentMeta;

class StickyHelper
{
    public const META_KEY = 'sticky_post';

    public static function isSticky(int $contentId): bool
    {
        return ContentMeta::where('content_id', $contentId)
            ->where('meta_key', self::META_KEY)
            ->where('meta_value', '1')
            ->exists();
    }

    public static function setSticky(int $contentId, bool $sticky): void
    {
        if ($sticky) {
            ContentMeta::updateOrCreate(
                ['content_id' => $contentId, 'meta_key' => self::META_KEY],
                ['meta_value' => '1']
            );
        } else {
            ContentMeta::where('content_id', $contentId)
                ->where('meta_key', self::META_KEY)
                ->delete();
        }
    }

    /**
     * Return IDs of all sticky posts, ordered by when they were pinned.
     * Used by themes/repositories to sort sticky items to the top:
     *
     *   $stickyIds = StickyHelper::stickyIds();
     *   $query->orderByRaw('FIELD(id, ' . implode(',', $stickyIds) . ') DESC');
     */
    public static function stickyIds(): array
    {
        return ContentMeta::where('meta_key', self::META_KEY)
            ->where('meta_value', '1')
            ->pluck('content_id')
            ->toArray();
    }
}
