# 📖 Overview

## Background

This project was built as part of a 6th-semester internship, driven by the need for a centralized public audio system that could replace manual or per-device music management. Previously, audio (background music in lobbies, rooms, etc.) was managed manually with no centralized, software-based control.

## Main Objective

To provide a **centralized web platform** for managing and broadcasting music/audio to multiple zones/channels automatically over the network. Operators simply upload songs, create playlists, assign them to zones, and streaming runs automatically without constant manual intervention.

## Key Features (Summary)

- Playlist management (CRUD) with auto-generated Liquidsoap configuration
- Song upload (MP3/MP4) with automatic MP4 → MP3 conversion via FFmpeg
- Per-playlist audio streaming via Icecast (separate mount point per playlist)
- Dashboard monitoring of stream status (online/offline, listener count)
- Role-based access control per playlist (owner, editor, viewer)
- User and access management (admin panel)
- REST API with token authentication (Laravel Sanctum)
- STB (Set-Top Box) IP monitoring per playlist

## Team & Contributors

Based on the repo context, this is a solo/individual project developed during a 6th-semester internship. Single role: developer (backend, frontend, DevOps/deployment, system design).

## Development Timeline

Approximately **±6 weeks** — based on the timestamp of the earliest migration (January 7, 2026) through the latest migration and `STREAMING_GUIDE.md` (February 12–14, 2026), consistent with the 6th-semester internship duration.
