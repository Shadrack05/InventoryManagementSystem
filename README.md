<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# Inventory Management System

A robust inventory management system built with Laravel and Vue.js that helps businesses track products, manage stock across multiple branches and stores, and monitor sales and transfers.

## Features

- **Multi-level Access Control**
  - Admin dashboard for system-wide management
  - Branch-level management
  - Store-level operations
  - Role-based access control

- **Product Management**
  - Product creation and tracking
  - SKU management
  - Price management

- **Inventory Control**
  - Real-time stock tracking
  - Stock transfer between stores

- **Sales Management**
  - Sales recording
  - Sales history
  - Sales reports by store/branch

- **Branch & Store Management**
  - Multiple branch support
  - Store management under branches
  - Store-specific inventory tracking

## Technology Stack

- **Backend:** Laravel 10.x
- **Frontend:** Vue.js 3
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Authorization:** Spatie Laravel-Permission
- **UI Framework:** Tailwind CSS

## Installation

1. Clone the repository:
```bash
git clone https://github.com/yourusername/inventory-management.git
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install NPM dependencies:
```bash
npm install
```

4. Create environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env` file

7. Run migrations and seeders:
```bash
php artisan migrate 
```

8. Start the development server:
```bash
php artisan serve
npm run dev
```

**Important**: Access the application using `localhost:8000` instead of `127.0.0.1:8000` to ensure proper Sanctum authentication functionality.

## Configuration Notes

### Sanctum Setup
- Use `localhost:8000` in your browser
- Using `127.0.0.1:8000` may cause CSRF token mismatches and authentication issues
- Ensure your `.env` file has:
  ```
  SANCTUM_STATEFUL_DOMAINS=localhost:8000
  SESSION_DOMAIN=localhost
  ```

## Usage

### User Roles

- **Admin**: Full system access
- **Branch Manager**: Access to specific branch and its stores
- **Store Manager**: Access to specific store operations

### Key Operations

1. **Product Management**
   - Add/Edit/Delete products
   - Set pricing

2. **Inventory Control**
   - Add/Remove stock
   - Transfer stock between stores
   - View stock levels

3. **Sales Processing**
   - Record sales
   - View sales history
   - Generate reports

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
