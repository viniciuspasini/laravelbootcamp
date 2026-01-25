# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

This is a Laravel 12 application (PHP 8.2+) set up as part of a Laravel bootcamp. The project uses:
- **Framework**: Laravel 12.x
- **Frontend**: Vite + Tailwind CSS v4
- **Testing**: Pest PHP (v4)
- **Code Quality**: Laravel Pint (code formatting)

## Development Commands

### Initial Setup
```bash
composer setup
```
This runs the complete setup: installs dependencies, creates .env file, generates app key, runs migrations, installs npm packages, and builds assets.

### Development Server
```bash
composer dev
```
Runs three concurrent processes:
- PHP development server (`php artisan serve`)
- Queue worker (`php artisan queue:listen --tries=1`)
- Vite dev server with HMR (`npm run dev`)

Alternatively, run services individually:
```bash
php artisan serve          # Start Laravel dev server (http://localhost:8000)
npm run dev               # Start Vite dev server with hot reload
php artisan queue:listen  # Start queue worker
```

### Testing
```bash
composer test             # Run full test suite (clears config first)
php artisan test          # Run tests directly
php artisan test --filter TestName  # Run specific test
```

Tests use Pest PHP with:
- In-memory SQLite database
- Array cache/mail/session drivers
- Feature tests in `tests/Feature/`
- Unit tests in `tests/Unit/`

### Code Quality
```bash
./vendor/bin/pint         # Format code with Laravel Pint
./vendor/bin/pint --test  # Check formatting without changes
```

### Building Assets
```bash
npm run build            # Production build with Vite
```

### Database
```bash
php artisan migrate             # Run migrations
php artisan migrate:fresh       # Drop all tables and re-run migrations
php artisan migrate:fresh --seed # Fresh migration + seed data
php artisan db:seed            # Run database seeders
```

### Other Useful Commands
```bash
php artisan tinker            # Interactive REPL
php artisan route:list        # List all routes
php artisan config:clear      # Clear config cache
php artisan cache:clear       # Clear application cache
php artisan view:clear        # Clear compiled views
php artisan pail              # Real-time log monitoring (Laravel Pail)
```

## Project Structure

### Application Layer
- `app/Http/Controllers/` - HTTP controllers (currently only base Controller.php)
- `app/Models/` - Eloquent models (User.php included by default)
- `app/Providers/` - Service providers (AppServiceProvider.php)

### Routes
- `routes/web.php` - Web routes (currently just welcome page)
- `routes/console.php` - Console/Artisan commands

### Frontend
- `resources/views/` - Blade templates
- `resources/css/app.css` - CSS entry point (Tailwind)
- `resources/js/app.js` - JavaScript entry point
- `public/` - Public assets (compiled assets go to `public/build/`)
- `vite.config.js` - Vite configuration with Laravel plugin and Tailwind CSS v4

### Database
- `database/migrations/` - Database migrations (users, cache, jobs tables included)
- `database/factories/` - Model factories for testing (UserFactory.php)
- `database/seeders/` - Database seeders (DatabaseSeeder.php)

### Testing
- `tests/Feature/` - Feature tests (integration tests)
- `tests/Unit/` - Unit tests
- `tests/Pest.php` - Pest configuration (extends TestCase, binds to Feature directory)
- `phpunit.xml` - PHPUnit/Pest configuration

### Configuration
- `config/` - All Laravel configuration files
- `bootstrap/app.php` - Application bootstrap (routing, middleware, exceptions)
- `.env` - Environment variables (not in git)

## Architecture Notes

### Application Bootstrap (Laravel 12)
This project uses Laravel 12's streamlined bootstrap configuration in `bootstrap/app.php`:
- Routes configured via `withRouting()` (web routes, console commands, health check at `/up`)
- Middleware configured via `withMiddleware()`
- Exception handling via `withExceptions()`

### Frontend Stack
- **Vite**: Modern build tool replacing Laravel Mix
- **Tailwind CSS v4**: Utility-first CSS framework (latest version)
- **Hot Module Replacement**: Enabled in dev mode via Vite
- Asset inputs: `resources/css/app.css` and `resources/js/app.js`
- Compiled output: `public/build/`

### Testing Configuration
Pest is configured to:
- Use `Tests\TestCase` as base class for Feature tests
- Use in-memory SQLite for database tests (`:memory:`)
- Database RefreshDatabase trait is commented out in `tests/Pest.php` - uncomment when needed
- Custom expectation example: `toBeOne()` extends Pest's expect() API

### Database Defaults
Initial migrations include:
- `users` table (with email verification, password, remember token)
- `cache` and `cache_locks` tables
- `jobs`, `job_batches`, `failed_jobs` tables for queue system

## Development Workflow

1. **Adding Features**: Create controllers in `app/Http/Controllers/`, define routes in `routes/web.php`, create views in `resources/views/`

2. **Database Changes**: Create migrations with `php artisan make:migration`, run with `php artisan migrate`

3. **Models**: Generate with `php artisan make:model ModelName -mf` (includes migration and factory)

4. **Tests**: Write Pest tests in `tests/Feature/` or `tests/Unit/`, run with `composer test`

5. **Frontend Changes**: Edit files in `resources/`, changes hot-reload automatically when `npm run dev` is running

6. **Queue Jobs**: Create with `php artisan make:job`, ensure queue worker is running for processing
