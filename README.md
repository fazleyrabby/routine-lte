# Routine Management System

Class schedule management system built with **Laravel 13** + **Tabler** admin template.

<img width="907" height="710" alt="CleanShot 2026-08-08 at 00 57 58" src="https://github.com/user-attachments/assets/165e4fd8-cb87-479f-b5e4-925d7e9dbca5" />

## Features

- Batch-wise routine viewing and PDF export
- Teacher management, workloads, and off-day assignments
- Course, room, section, and time slot management
- Main sheet routine data entry with conflict detection
- Teacher-wise and full routine views

## Quick Start (Local)

```bash
cp .env.example .env
# Edit .env with your DB credentials
composer install
php artisan key:generate
php artisan migrate:fresh --seed
php artisan serve
```

**Admin:** superadmin / 123456
**User:** alice_rahman / password

## Deploy

Push to `deploy` branch → auto-deploys via GitHub Actions self-hosted runner → `routine.fazleyrabbi.xyz`
