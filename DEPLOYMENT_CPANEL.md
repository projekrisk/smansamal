# Panduan Deployment SMAN 1 Malingping ke cPanel Shared Hosting (Tanpa Symlink)

Aplikasi portal SMAN 1 Malingping telah dirancang khusus agar **100% kompatibel dengan Shared Hosting cPanel standar tanpa memerlukan perintah `php artisan storage:link` (symlink)**.

---

## 1. Struktur Direktori cPanel yang Direkomendasikan

Pada shared hosting cPanel, pisahkan folder core Laravel dengan folder root web (`public_html`) untuk keamanan maksimal:

```text
/home/username/
├── portal_app/                 <-- Seluruh file Laravel (app, bootstrap, config, database, routes, resources, vendor, .env, dll)
└── public_html/                <-- Isi dari folder 'public' Laravel
    ├── build/                  <-- Asset CSS/JS terkompilasi dari Vite
    ├── uploads/                <-- Folder tempat seluruh gambar WebP tersimpan langsung (tanpa symlink)
    │   ├── articles/
    │   └── avatars/
    ├── .htaccess               <-- htaccess bawaan public
    ├── favicon.ico
    ├── robots.txt
    └── index.php               <-- Entry point yang disesuaikan
```

---

## 2. Penyesuaian `public_html/index.php`

Ubah path loader pada file `public_html/index.php` agar membaca core Laravel di `../portal_app`:

```php
<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../portal_app/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register Composer Autoloader...
require __DIR__.'/../portal_app/vendor/autoload.php';

// Bootstrap Laravel and handle request...
(require_once __DIR__.'/../portal_app/bootstrap/app.php')
    ->handleRequest(Request::capture());
```

---

## 3. Konfigurasi Upload Otomatis Tanpa Symlink

Pada file `config/filesystems.php`, disk `public` telah dikonfigurasi untuk mendeteksi `public_html` secara otomatis:

```php
'public' => [
    'driver' => 'local',
    'root' => env('PUBLIC_UPLOADS_PATH')
        ? env('PUBLIC_UPLOADS_PATH')
        : (is_dir(base_path('../public_html')) ? base_path('../public_html/uploads') : public_path('uploads')),
    'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/uploads',
    'visibility' => 'public',
    'throw' => false,
    'report' => false,
],
```

Pada `App\Providers\AppServiceProvider.php`, binding `public_path()` telah diaktifkan:
```php
if (is_dir(base_path('../public_html'))) {
    $this->app->usePublicPath(base_path('../public_html'));
}
```

Pastikan folder `public_html/uploads` memiliki permission `755` pada cPanel File Manager.

---

## 4. Konfigurasi `.env` Produksi Hosting

```env
APP_NAME="SMAN 1 Malingping"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sman1malingping.sch.id

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=username_sman1malingping
DB_USERNAME=username_dbuser
DB_PASSWORD="PasswordKuatDatabase123!"

FILESYSTEM_DISK=public

# Konfigurasi SMTP Email Hosting Sekolah
MAIL_MAILER=smtp
MAIL_HOST=mail.sman1malingping.sch.id
MAIL_PORT=465
MAIL_USERNAME=info@sman1malingping.sch.id
MAIL_PASSWORD="PasswordEmailSekolah123!"
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="info@sman1malingping.sch.id"
MAIL_FROM_NAME="SMAN 1 Malingping"
```

---

## 5. Perintah Optimasi Produksi (Jalankan via Terminal cPanel atau SSH)

```bash
# Masuk ke direktori aplikasi
cd /home/username/portal_app

# Migrasi & Database Seeder (jika pertama kali)
php artisan migrate --force

# Caching Konfigurasi & Route untuk PageSpeed 90+
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 6. Akun Default Pengelola & Pengujian

- **Super Admin**: `superadmin@sman1malingping.sch.id` (Password: `password`)
- **Admin Guru**: `admin@sman1malingping.sch.id` (Password: `password`)
- **Siswa Aktif**: `nabila@sman1malingping.sch.id` (Password: `password`)
- **Alumni**: `dimas@sman1malingping.sch.id` (Password: `password`)
