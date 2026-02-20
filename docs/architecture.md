# System Architecture

## Overview

Obsidian Radio Broadcast uses a containerized micro-infrastructure
approach to manage radio streaming operations.

## Components

### 1. Laravel Control Panel
Responsible for:
- Playlist management
- Song metadata management
- Liquidsoap configuration generation
- System monitoring

### 2. Liquidsoap
Audio automation engine that:
- Loads playlist
- Handles fallback
- Encodes audio stream
- Pushes stream to Icecast

### 3. Icecast
Streaming distribution server that:
- Accepts audio stream from Liquidsoap
- Distributes stream to listeners

---

## Data Flow

1. Admin updates playlist in Laravel.
2. Laravel generates M3U playlist file.
3. Laravel triggers Liquidsoap reload.
4. Liquidsoap streams audio to Icecast.
5. Icecast distributes stream to listeners.

---

## Deployment Model

Docker containers:
- app (Laravel)
- icecast
- liquidsoap
- nginx
- database