## Spatie Laravel Permission Package
```
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan optimize:clear
php artisan migrate
```

## Create Role
```
php artisan permission:create-role user
```

## Create Middleware
- Copy Route Middleware in Kernel.php
