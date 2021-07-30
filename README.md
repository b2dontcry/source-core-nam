<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Getting Started

Lần lượt chạy các lệnh:

``` bash
composer require hisorange/browser-detect nwidart/laravel-modules
```

``` bash
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

```bash
rm ./database/migrations/*_create_users_table.php
```

Tạo database sau đó chạy lệnh để tạo bảng và dữ liệu ban đầu:

```bash
php artisan migrate && php artisan module:seed UserAndPermission
```

Để chạy được giao diện cần phải build css và js. Chạy lệnh:

```bash
cd ./Modules/UserAndPermission
```

```bash
npm install
```

```bash
bash update-resource.sh
```

```bash
npm run dev
```

Trong file "app/Http/Kernel.php" ở dòng "$routeMiddleware" thêm các dòng như sau:

```text
protected $routeMiddleware = [
    ...
    'CheckClientCredentials' => \Modules\UserAndPermission\Http\Middleware\CheckClientCredentials::class,
    'check_user_permissions' => \Modules\UserAndPermission\Http\Middleware\CheckUserPermission::class,
    'check_locale' => \Modules\UserAndPermission\Http\Middleware\CheckLocale::class,
    'check_login_first_time' => \Modules\UserAndPermission\Http\Middleware\CheckLoginFirstTime::class,
];
```

Ở thư mục gốc mở file composer.json và sửa nội dung để chạy autoload `psr-4`:

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "Modules/"
    }
  }
}
```
**Sau khi cấu hình autoload psr-4 cho module thì chạy `composer dump-autoload`.**
