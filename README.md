# Sticky Posts

Pin posts to the top of archive and homepage listings. Sticky posts always appear before other posts regardless of publish date. Managed from a dedicated admin page - no code editing required.

**Features:**
- Pin or unpin any published post from the admin settings page
- Pinned posts flagged with a star icon in the admin list
- Dashboard quick-action badge shows the count of currently pinned posts
- `StickyHelper::stickyIds()` returns all pinned IDs - ready to use in any theme query
- Stored in the core `content_meta` table - no migrations required
- Settings hub card in Admin > Settings

---

## Requirements

- Contensio 2.0 or later

---

## Installation

### Composer

```bash
composer require contensio/plugin-sticky-posts
```

### Manual

Copy the plugin directory and register the service provider via the admin plugin manager.

No migrations required.

---

## Configuration

Go to **Admin > Settings > Sticky Posts**.

The page lists all published posts. Each row has a **Pin to top** or **Unpin** button. Changes take effect immediately.

---

## Using sticky posts in themes

Themes and custom repositories use `StickyHelper::stickyIds()` to sort pinned posts to the top:

```php
use Contensio\Plugins\StickyPosts\Support\StickyHelper;

$stickyIds = StickyHelper::stickyIds();

$posts = Content::where('status', 'published')
    ->when(! empty($stickyIds), function ($q) use ($stickyIds) {
        $ids = implode(',', $stickyIds);
        $q->orderByRaw("FIELD(id, {$ids}) DESC");
    })
    ->orderByDesc('published_at')
    ->paginate(10);
```

The `FIELD()` trick puts the sticky IDs first in the result set. Non-sticky posts fall back to the normal `published_at` order. If the `stickyIds` array is empty, the `orderByRaw` is skipped entirely.

---

## Hook reference

| Hook | Description |
|------|-------------|
| `contensio/admin/settings-cards` | Settings hub card |
| `contensio/admin/dashboard-quick-actions` | Shows pinned post count badge on the dashboard |

---

## Database storage

| Column | Value |
|--------|-------|
| `content_id` | ID of the pinned post |
| `meta_key` | `sticky_post` |
| `meta_value` | `1` |
