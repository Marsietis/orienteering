# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is an orienteering competition platform built with Laravel 11 and Vue 3 using Inertia.js. The application manages orienteering tasks, user submissions, and scoring/leaderboards. It features a dual interface: a public frontend for participants and a Filament admin panel for administrators.

## Core Models and Architecture

### Database Models
- **User**: Handles authentication and tracks user points. Contains a special admin access method (`canAccessPanel`) that restricts admin access to `slagbaumas.algis@knf.stud.vu.lt`
- **Task**: Orienteering challenges with title, description, points value, and optional images
- **Submission**: User submissions for tasks, including image uploads and admin approval status
- **Events**: Competition events with start/end dates
- **Member**: Additional member information linked to users

### Key Relationships
- Users have many Submissions and Members
- Tasks have many Submissions  
- Submissions belong to both User and Task

## Development Commands

### Backend (Laravel)
```bash
# Start development environment
./vendor/bin/sail up

# Database operations
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan migrate:fresh --seed

# Code style and quality
./vendor/bin/pint                    # Fix code style
./vendor/bin/pint --test            # Check code style without fixing
php artisan test                    # Run PHPUnit tests

# Artisan commands
php artisan make:migration <name>
php artisan make:model <name>
php artisan make:controller <name>
php artisan make:resource <name>
```

### Frontend (Vue/Vite)
```bash
# Development server
npm run dev

# Production build
npm run build
```

## Application Architecture

### Frontend Stack
- **Vue 3** with Composition API
- **Inertia.js** for SPA-like experience without API complexity
- **Tailwind CSS** for styling
- **Ziggy** for route helpers in JavaScript

### Backend Stack
- **Laravel 11** framework
- **Filament 3.x** for admin panel interface
- **Laravel Breeze** for authentication scaffolding
- **SQLite** database (development)

### File Storage
- Task images stored in `storage/app/public/task-images/`
- Submission images stored in `storage/app/public/submissions/`
- Public files served from `public/storage/` via symlink

## Key Directories

### Backend
- `app/Models/` - Eloquent models
- `app/Http/Controllers/` - Route controllers for public interface
- `app/Filament/Resources/` - Admin panel resources and forms
- `database/migrations/` - Database schema definitions

### Frontend
- `resources/js/Pages/` - Inertia.js Vue components (pages)
- `resources/js/Components/` - Reusable Vue components
- `resources/js/Layouts/` - Layout components

## Admin Panel (Filament)

Access restricted to specific email address in `User::canAccessPanel()`. Provides CRUD interfaces for:
- Tasks (with image upload to `task-images/`)
- Users management
- Submission review and approval
- Events management
- Member management

## Authentication & Authorization

Uses Laravel Breeze with Inertia.js setup. Admin panel access is hardcoded to specific email in User model. Regular users can register, submit task solutions, and view leaderboards.

## Testing

- PHPUnit configured with separate testing database
- Feature tests for authentication flow
- Example tests provided in `tests/Feature/` and `tests/Unit/`

## Docker Setup

Uses Laravel Sail for local development with Docker. The README mentions sail commands but has a typo (`./vendon/bin/sail` should be `./vendor/bin/sail`).