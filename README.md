# Laravel Admin Google Authenticator

Two-Factor Authentication (2FA) extension for [Laravel Admin](https://github.com/z-song/laravel-admin) using Google Authenticator.

## Features

- Enable/Disable 2FA for individual admin users
- QR code scanning for easy setup
- Verification page for 2FA codes
- Configurable settings via .env file
- Middleware protection for admin routes

## Installation

1. Install the package via Composer:
   ```bash
   composer require tech-djoin/laravel-admin-ext-google-authenticator
   ```

2. Publish assets and configuration:
   ```bash
   php artisan vendor:publish --provider="TechDjoin\LaravelAdminGoogleAuthenticator\GoogleAuthenticatorServiceProvider" --tag="config"
   ```

3. Customize the configuration file in `config/google2fa.php` as needed.

4. Run migrations:
   ```bash
   php artisan migrate
   ```

5. Override the `Administrator.php` file in the `/vendor/encore/laravel-admin/src/Auth/Database` directory and update your admin user model (usually in `App/Models/AdminUser.php`):

   ```php
   <?php

   namespace App\Models;

   use Encore\Admin\Auth\Database\Administrator;
   use Illuminate\Notifications\Notifiable;
   use TechDjoin\LaravelAdminGoogleAuthenticator\Traits\Google2FAAuthenticatableTrait;

   class AdminUser extends Administrator
   {
      use Notifiable;
      use Google2FAAuthenticatableTrait;

      protected $fillable = ['username', 'password', 'name', 'avatar', 'google2fa_secret'];

      public function setGoogle2faSecretAttribute($value)
      {
         $this->attributes['google2fa_secret'] = !is_null($value) ? encrypt($value) : null;
      }

      public function getGoogle2faSecretAttribute($value)
      {
         return isset($value) ? decrypt($value) : null;
      }
   }
   ```

6. Update `config/admin.php`:

   ```php
   'auth' => [
       'model' => App\Models\AdminUser::class,
   ],

   'database' => [
      'users_model' => App\Models\AdminUser::class
   ],
   ```

7. Install PHP Imagick extension for QR code generation.

## Configuration (Optional)

You can configure the extension by editing `config/google2fa.php` or setting values in your `.env` file:

```
ADMIN_2FA_ENABLED=true
ADMIN_2FA_LIFETIME=0
ADMIN_2FA_KEEP_ALIVE=true
```

## Installing Imagick PHP Extension

### Windows

1. Download and extract files from [PECL Imagick Extension](https://windows.php.net/downloads/pecl/releases/imagick/).
2. Copy `php_imagick.dll` to the PHP `ext` folder.
3. Copy all `.dll` files from the `bin` folder to the main PHP folder.
4. Edit `php.ini`, add the line `extension=imagick`.
5. Restart the web server.

### Linux (Ubuntu/Debian)

1. Update repository:
   ```bash
   sudo apt update
   ```

2. Install Imagick:
   - PHP 7.x: `sudo apt install php-imagick`
   - PHP 8.x: `sudo apt install php8.x-imagick`

3. Restart web server:
   - Apache: `sudo systemctl restart apache2`
   - Nginx: `sudo systemctl restart nginx`

Verify the installation by running `php -m | grep imagick`.
