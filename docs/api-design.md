# 🔌 API Design

## API Type

**REST API** — HTTP method-based endpoints (GET, POST, PUT/PATCH, DELETE). Authentication via **Laravel Sanctum** (token-based). No WebSocket or GraphQL currently.

## Endpoint List

### Auth API

| Method | Path | Function |
|---|---|---|
| `POST` | `/api/login` | Login, returns a Sanctum token |

### User API *(Admin only)*

| Method | Path | Function |
|---|---|---|
| `GET` | `/api/users` | List all users |
| `GET` | `/api/users/{user}/playlists` | List playlists owned by a user |
| `POST` | `/api/users/{user}/playlists` | Sync a user's playlist access |

### Playlist API *(Authenticated)*

| Method | Path | Function |
|---|---|---|
| `GET` | `/api/my-playlists` | List playlists accessible to the logged-in user |

### Web Routes — Streaming *(Public, no auth)*

| Method | Path | Function |
|---|---|---|
| `GET` | `/stream/{playlist_slug}` | Returns the `.m3u` file for a playlist |
| `GET` | `/stream/song/{song_id}` | Streams the MP3 audio file (supports HTTP Range) |

### Web Routes — Dashboard *(Auth required)*

| Method | Path | Function |
|---|---|---|
| `GET` | `/dashboard` | Main dashboard |
| `GET` | `/playlists` | Playlist index |
| `POST` | `/playlists` | Create a playlist + auto-generate Liquidsoap config |
| `PUT` | `/playlists/{playlist}` | Update a playlist |
| `DELETE` | `/playlists/{playlist}` | Delete a playlist + clean up its M3U |
| `GET` | `/playlists/{playlist}/status` | Stream status from Icecast (JSON) |
| `GET` | `/playlists/status/all` | Status for all playlists (JSON) |
| `POST` | `/playlists/{playlist}/songs` | Update the songs in a playlist |
| `POST` | `/playlists/{playlist}/add-song` | Add a single song to a playlist |
| `POST` | `/songs` | Upload a new song |
| `DELETE` | `/songs/{song}` | Delete a song |

### Admin Routes

| Method | Path | Function |
|---|---|---|
| `GET` | `/admin/user-access` | List users + their playlist access |
| `POST` | `/admin/user-access` | Add a new user |
| `PATCH` | `/admin/user-access/{user}/playlist/{playlist}/role` | Update a user's role for a playlist |

## API Authentication

**Laravel Sanctum** for API routes (`auth:sanctum` middleware). A token is generated on `POST /api/login` and sent via the `Authorization: Bearer {token}` header for subsequent requests. Web routes (dashboard) use session-based auth (`auth` middleware) with a login form at `/login`.

## Request/Response Format

**Login request:**

```json
POST /api/login
{ "username": "admin", "password": "password123" }
```

**Playlist status response:**

```json
GET /playlists/status/all
{
  "lobby": { "online": true, "listeners": 3, "title": "Relaxing Piano", "bitrate": 128 },
  "cafe": { "online": false }
}
```

**My playlists response:**

```json
GET /api/my-playlists
[
  {
    "id": 1, "name": "Lobby Music", "slug": "lobby-music",
    "is_public": true,
    "stream_url": "http://127.0.0.1:8010/lobby-music",
    "pivot": { "role": "owner" }
  }
]
```

## Error Handling

Uses Laravel's default error handling:

| Code | Meaning |
|---|---|
| `401` | Unauthenticated (redirects to `/login` for web, JSON for API) |
| `403` | Forbidden (unauthorized access based on Policy/role) |
| `404` | Not Found (playlist/song doesn't exist) |
| `422` | Validation Error (invalid request, with field-level error details) |
| `500` | Server Error (exception, with stack trace in development) |

Streaming error response example:

```json
{ "online": false, "error": "Icecast server not reachable" }
```
