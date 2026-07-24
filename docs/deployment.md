# 🚀 Deployment

## Deployment Environment

**On-premise / VPS** — based on the environment path (`/var/www/project-root/`). For development: localhost on Windows. For production: a Linux server (VPS/dedicated) with the path `/var/www/project-root/`.

## Build & Deployment Process

- **Docker Compose** for Icecast + Liquidsoap (two containers)
- The **Laravel app** runs directly (PHP built-in server / Nginx) — it is not dockerized
- No CI/CD pipeline currently in place (manual deployment)

## Environment Variables

```env
# Laravel
APP_KEY=            # Generate via: php artisan key:generate
APP_URL=http://127.0.0.1
DB_HOST=127.0.0.1
DB_DATABASE=mosec
DB_USERNAME=root
DB_PASSWORD=

# Icecast
ICECAST_HOST=icecast
ICECAST_PORT=8000                         # Internal Docker port
ICECAST_PASSWORD=hackme
ICECAST_PUBLIC_URL=http://127.0.0.1:8010  # Public port (host mapping)

# Liquidsoap paths (host paths, mounted into the container)
LIQUIDSOAP_M3U_PATH=/var/www/project-root/music
LIQUIDSOAP_CONFIG_PATH=/var/www/project-root/liquidsoap/radio.liq
LIQUIDSOAP_MUSIC_BASE_PATH=/music

# Limits
MAX_PLAYLISTS=20
MAX_SONGS_PER_PLAYLIST=500
STREAM_BITRATE=128

# Tools
FFMPEG_PATH=/usr/bin/ffmpeg
```

## Requirements Before Deployment

- Docker & Docker Compose installed
- **PHP 8.1+** with the following extensions: `pdo_mysql`, `mbstring`, `fileinfo`, `tokenizer`, `xml`
- MySQL running (with the `mosec` database created)
- FFmpeg available (bundled as `ffmpeg.exe` on Windows; install via `apt` on Linux)
- Port **8010** open for Icecast (stream access)
- The folder `/var/www/project-root/music/` writable by the web server
- The folder `/var/www/project-root/liquidsoap/` writable for generating `radio.liq`

## Installation / Deployment Steps

```bash
# 1. Clone the repo
git clone <repo-url> /var/www/project-root
cd /var/www/project-root

# 2. Set up the Laravel app
cd musik-control
composer install
cp .env.example .env
php artisan key:generate
# Edit .env according to your environment

# 3. Set up the database
php artisan migrate
php artisan db:seed   # (if a seeder exists)

# 4. Set up the storage link
php artisan storage:link

# 5. Create the music folder & set permissions
mkdir -p /var/www/project-root/music
chmod 755 /var/www/project-root/music

# 6. Start Docker (Icecast + Liquidsoap)
cd /var/www/project-root
docker compose up -d

# 7. Run Laravel
cd musik-control
php artisan serve   # development
# (production: use Nginx + php-fpm)
```
