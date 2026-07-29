# Routine LTE — Docker & Project Documentation

## Docker Architecture

Restructured to follow the **single-container app pattern** (matching erp/LitePos):

```
┌─────────────────────────────────────┐
│  app container (routine-lte-app)    │
│  ┌──────────┐  ┌──────────────────┐ │
│  │  nginx    │  │  php-fpm 8.3     │ │
│  │  :80      │◄─┤  + extensions    │ │
│  └────┬─────┘  │  + redis ext     │ │
│       │        └──────────────────┘ │
│       │  ┌──────────────────────┐   │
│       └──┤  supervisor          │   │
│          │  (manages both)     │   │
│          └──────────────────────┘   │
└─────────────────┬───────────────────┘
                  │
    ┌─────────────┼─────────────┐
    ▼             ▼             ▼
  mysql:8.0   redis:7-alpine   [Traefik (prod)]
```

## Services

| Service | Image | Local Port | Purpose |
|---------|-------|-----------|---------|
| **app** | `php:8.3-fpm` (custom) | `8080:80` | Nginx + PHP-FPM + Supervisor |
| **mysql** | `mysql:8.0` | `3307:3306` | Database |
| **redis** | `redis:7-alpine` | `6380:6379` | Cache/Queue |

## What Changed

### Dockerfile
- **PHP**: 8.0 → **8.3-fpm** (matches Laravel 13 requirement)
- **Nginx**: separate container → **bundled into app container**
- **Supervisor**: added to manage nginx + php-fpm together
- **Redis extension**: added (`pecl install redis`)
- **Working dir**: `/var/www` → `/var/www/html`
- **Config files**: moved from `docker-compose/` → `docker/`

### docker-compose.yml
- Removed `version` key (modern versionless format)
- Merged nginx service into app container
- Removed phpMyAdmin service
- Added Redis service
- Changed app port from `443` → `8080:80`
- Removed custom network port mapping (`443`)
- Added persistent volumes for mysql and redis data

### docker-compose.prod.yml (new)
- Production-grade setup with **Traefik** labels
- Uses **external networks** for shared MySQL and Traefik
- Startup command fixes permissions + creates storage symlink
- Only mounts `storage/` and `bootstrap/cache` (not full source)

### docker/ (new)
Replaces old `docker-compose/` directory:
- `docker/nginx.conf` — Nginx config (root: `/var/www/html/public`)
- `docker/supervisord.conf` — Manages nginx + php-fpm
- `docker/php-local.ini` — PHP settings (memory, upload limits, opcache)

### Environment
- `DB_HOST`: `localhost` → `mysql` (Docker service name)
- `REDIS_HOST`: `127.0.0.1` → `redis` (Docker service name)
- Added `DB_ROOT_PASSWORD` env var

## Usage

### Local Development
```bash
# Build and start
docker compose up -d

# Or rebuild after Dockerfile changes
docker compose up -d --build

# Stop
docker compose down

# View logs
docker compose logs -f app

# Run artisan inside container
docker compose exec app php artisan migrate

# Install composer dependencies
docker compose exec app composer install

# Access app
open http://localhost:8080
```

### Production Deployment
```bash
# Deploy with Traefik + shared MySQL
docker compose -f docker-compose.prod.yml up -d --build
```

Requires external networks:
```bash
docker network create traefik
docker network create mysql-shared
```

## UI Migration: AdminLTE → Tabler Admin

### What Changed

| Aspect | Before | After |
|--------|--------|-------|
| **Framework** | AdminLTE 3 (Bootstrap 4) | Tabler 1.4 (Bootstrap 5) |
| **Font** | Source Sans Pro | Inter |
| **Layout** | `.wrapper` > `.content-wrapper` | `.page` > `.page-wrapper` > `.page-header` + `.page-body` |
| **Navbar** | Single nav with dropdowns | Tabler horizontal navbar with dropdown menus |
| **Breadcrumbs** | `.content-header` with `breadcrumb` | `.page-header` with `breadcrumb breadcrumb-arrows` |
| **Footer** | `.main-footer` | `.footer.footer-transparent` |
| **Login page** | Custom full-page background | Tabler `.page-center` centered layout |
| **Assets** | `public/backend/dist/css/adminlte.min.css` | `public/backend/tabler/css/tabler.css` |
| **JS** | `adminlte.min.js` + `demo.js` | `tabler-theme.min.js` + `tabler.min.js` |

### File Structure
```
├── docker/
│   ├── nginx.conf
│   ├── supervisord.conf
│   └── php-local.ini
├── docker-compose.yml          # Local development
├── docker-compose.prod.yml     # Production deployment
├── Dockerfile
├── .env
├── public/backend/tabler/      # Tabler assets
│   ├── css/
│   ├── js/
│   └── libs/
└── docs/
    └── doc.md                  # This file
```
