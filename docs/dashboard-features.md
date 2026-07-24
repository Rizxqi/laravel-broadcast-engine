# 📊 Dashboard Features

## Full Feature List

| Feature | Description |
|---|---|
| **Dashboard Overview** | View all accessible playlists, stream status (online/offline), and song count per playlist |
| **Playlist CRUD** | Create, edit, delete playlists; automatically generates Liquidsoap configuration and `.m3u` files |
| **Song Management** | Upload songs (MP3/MP4), auto-convert MP4 to MP3 via FFmpeg, delete songs |
| **Playlist-Song Assignment** | Add/remove songs to a playlist, reorder songs via drag-and-drop, update playback order |
| **Stream Status Monitoring** | Check Icecast status per playlist (online/offline, listener count, currently playing title, bitrate) |
| **User Access Management** *(Admin)* | CRUD users, assign playlists to users, set role (owner/editor/viewer) |
| **STB IP Monitoring** | Store and track the STB IP address per playlist/zone |
| **Stream URL Access** | Access the stream URL directly from the dashboard to send to STB devices |

## Zone/Location Management

**Yes, indirectly.** Each playlist represents one streaming zone/channel (a separate Icecast mount point). The `stb_ip` field on the `playlists` table stores the STB IP that plays that zone. There is no explicit UI grouping by floor/area yet, but the playlist name can reflect its zone.

## Scheduling

**Not yet implemented** — listed as a "Next Step" in `STREAMING_GUIDE.md` (time-based playlist scheduling). Currently, a playlist runs continuously as long as Liquidsoap is active.

## Live Broadcast / Announcements

**Not yet implemented** — no live mic/announcement implementation was found. The system currently only supports automatic playlist/music streaming. Live broadcast is noted as a potential future feature.

## Playlist / Audio Library Management

**Yes, fully implemented:**

- Upload songs (MP3/MP4) to a global library
- Auto-convert MP4 → MP3 via FFmpeg
- Add songs from the library to any playlist
- Remove songs from a playlist (detach) or from the library (delete)
- Reorder songs within a playlist via drag-and-drop
- Song metadata: title, duration (read via getID3)

## Emergency Broadcast

**Not yet implemented** — no emergency broadcast feature that overrides all zones. However, Liquidsoap is already configured with a `blank()` fallback (silence) if a playlist is empty or a file is unavailable, preventing fatal errors.

## Device Status Monitoring

**Yes, for Icecast stream status:**

- Online/offline status per playlist (polled from the Icecast status API)
- Active listener count
- Currently playing title
- Stream bitrate
- Cache TTL: 10 seconds (to avoid overloading Icecast)

Hardware STB monitoring (ping/health check) is not yet implemented.

## Roles & Permissions

**Yes, two-level RBAC:**

| Level | Roles |
|---|---|
| **System level** | `admin` (full access to all playlists + user management) vs. `user` (access only to assigned playlists) |
| **Playlist level** | `owner` (full control including delete & share), `editor` (can edit songs & order), `viewer` (view only) |

Implemented via Laravel Policies + `admin` middleware.

## Screenshots

> Screenshots are not yet available (`/assets/screenshots` folder is empty in the repo). Add screenshots manually to complete this documentation.
