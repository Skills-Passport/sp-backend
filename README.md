# Installation and running locally guide

This guide will help you set up the Skills Passport backend application and run it locally.

## Prerequisites

- PHP >= 8.2
- Composer
- MySQL/MariaDB # or any other database but then change the `.env` file accordingly [Documention](https://laravel.com/docs/11.x/database)
- Git

## Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/Skills-Passport/sp-backend.git
cd sp-backend
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Configure Environment

1. Copy the `.env.example` file and rename it to `.env` either manually or via

```bash
cp .env.example .env
```

2. Configure your database settings in `.env`:
```env
DB_CONNECTION=mysql        # Database driver (MySQL is recommended)
DB_HOST=127.0.0.1          # Database host (localhost)
DB_PORT=3306               # MySQL default port
DB_DATABASE=your_db_name   # Name of your database
DB_USERNAME=your_user      # Database username
DB_PASSWORD=your_password  # Database password
```

3. Set application URLs:
```env
APP_URL=http://localhost:8000      # Backend URL
FRONTEND_URL=http://localhost:3000 # Frontend URL (must match with sp-frontend settings)
```

### 4. Application Setup

1. Generate application key:
```bash
php artisan key:generate
```

2. Run database migrations:
```bash
php artisan migrate
```

3. Seed the database:
```bash
php artisan db:seed
```
> this will including other thing create 4 users
+ student@sp.nl
+ teacher@sp.nl
+ head-teacher@sp.nl
+ admin@sp.nl

With the password for all being: `password`


### 5. Start the Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Frontend Integration

For the frontend setup, please refer to the [sp-frontend repository](https://github.com/davidhoen/sp-frontend).

## Troubleshooting

If you encounter any issues:
- Ensure all prerequisites are installed
- Verify database credentials are correct
- Check if ports 8000 and 3000 are available
- Make sure all environment variables are properly set

For more help, please create an issue in the GitHub repository.