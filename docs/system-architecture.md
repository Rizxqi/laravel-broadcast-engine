# 🏗️ System Architecture

## Architectural Style

**Client-server with Docker-based microservices.** There are 3 main layers:

1. **Control Layer** — Laravel app (web + API)
2. **Audio Processing Layer** — Liquidsoap container (mixer)
3. **Streaming Layer** — Icecast container (HTTP streaming server)

All three components are connected via the Docker network `radio-network`.

## Main Components

| Component | Detail |
|---|---|
| **Laravel App** (`musik-control/`) | Backend PHP — web dashboard, playlist/song CRUD, REST API, authentication, Liquidsoap config generation |
| **Liquidsoap Container** | Audio engine — reads `.m3u` files, encodes to MP3, pushes stream to Icecast |
| **Icecast Container** (host port 8010 → container port 8000) | HTTP streaming server — receives push from Liquidsoap, serves to clients over HTTP |
| **MySQL Database** | Stores users, playlists, songs, and role access data |
| **FFmpeg** (bundled) | Converts MP4 → MP3 during upload |
| **Docker Compose** | Orchestrates the Icecast + Liquidsoap containers |
| **STB (Set-Top Box)** | Endpoint device in each zone that plays the Icecast stream (via VLC or a built-in player) |

## Audio Data Flow

```
Operator uploads MP3/MP4
        │
        ▼
Laravel (SongController) → FFmpeg converts MP4→MP3
        │
        ▼
MP3 file stored in /music (shared volume)
        │
        ▼
Laravel (PlaylistController) → generates .m3u file + radio.liq
        │
        ▼
Liquidsoap Container (reads .m3u from /music)
        │
        ▼
Pushes audio stream to Icecast (mount point /{playlist-slug})
        │
        ▼
Icecast serves via HTTP: http://server:8010/{slug}
        │
        ▼
STB/VLC at the zone opens the stream URL → sound plays through the speaker
```

## Streaming Protocol

**HTTP audio streaming (Icecast2 protocol / SHOUTcast-compatible).** Format: **MP3 128kbps**. Clients (VLC, STB) open a plain HTTP URL and receive a continuous audio stream. An `.m3u` file acts as a playlist pointer for the player. Liquidsoap connects to Icecast internally as a `source` client.

## External Integrations

- **STB (Set-Top Box)** — Each zone has an STB with a static IP registered in the system (`stb_ip` field on the `playlists` table). The STB plays the stream from Icecast.
- **Speaker/Amplifier** — Connected to the STB's audio output; not directly controlled by the software (controlled via the STB hardware).
- **FFmpeg** — Bundled external tool (`ffmpeg.exe`) used for audio conversion.

There is currently no integration with a building's alarm/fire system.

## Architecture Diagram

An ASCII diagram exists in `musik-control/STREAMING_GUIDE.md`:

```
Laravel → Liquidsoap → Icecast → VLC/STB Player
```

A formal visual diagram is not yet available (`/assets/diagrams` still empty). The ASCII diagram above can serve as a base for a visual version.
