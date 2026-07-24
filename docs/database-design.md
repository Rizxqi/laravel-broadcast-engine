# 🗄️ Database Design

## Database Engine

**MySQL** (database name: `mosec`). Driver: `mysql` via PDO. Default host: `127.0.0.1:3306`.

## Main Tables

| Table | Function |
|---|---|
| `users` | User data: username, name, email, password, role (admin/user) |
| `playlists` | Playlists: name, slug, stb_ip, description, is_public |
| `songs` | Song library: title, file_path, duration |
| `playlist_song` | Pivot: many-to-many playlist ↔ song relationship + `order` column |
| `playlist_user` | Pivot: many-to-many playlist ↔ user relationship + `role` column (owner/editor/viewer) |
| `personal_access_tokens` | API tokens (Laravel Sanctum) |
| `password_reset_tokens` | Password reset tokens |
| `failed_jobs` | Failed queue jobs |

## Relationships Between Tables

- `playlists` **many-to-many** `songs` → via `playlist_song` (with a pivot `order` column for playback order)
- `playlists` **many-to-many** `users` → via `playlist_user` (with a pivot `role` column: owner/editor/viewer)
- A `user` can own many playlists (as owner/editor/viewer)
- A single `song` can belong to many playlists (shared library)

## ERD (Entity Relationship Diagram)

> A formal ERD file is not yet available. Simplified overview:

```
users ─────────── playlist_user ─────────── playlists
                  (role: owner/editor/viewer)    │
                                                 │
                                            playlist_song ────── songs
                                            (order: int)
```

## Design Considerations

- The `slug` column on `playlists` is used as the Icecast mount point (auto-generated from `name` via `Str::slug()`)
- The `stb_ip` column is indexed for fast device IP lookups per playlist
- The `playlist_song.order` pivot supports drag-and-drop playback ordering
- A unique constraint on `[user_id, playlist_id]` in `playlist_user` prevents duplicate access entries
- Audio files are stored on the filesystem (`storage/app/public/songs/`); the database only stores the `file_path` (relative filename)
- No audio binary data is stored in the database
