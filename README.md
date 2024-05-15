## About the repository

Laravel REST API dengan pendekatan Data Transfer Object (DTO), Repository Pattern, dan Sanctum Authentication memberikan kerangka kerja yang terstruktur, terorganisir, dan aman. DTO sebagai Contratcs untuk memformat dan memvalidasi data yang ditransfer antara berbagai lapisan aplikasi, menjaga keselarasan data dan meningkatkan keamanan. Repository Pattern memisahkan logika akses data dari logika bisnis, memfasilitasi pengujian terpisah dan maintenance yang lebih mudah, sementara Sanctum Authentication menyediakan lapisan keamanan yang kokoh dengan sistem token yang memungkinkan otentikasi API yang aman. Gabungan ini menciptakan arsitektur API yang skalabel, modular, dan dapat dipercaya, mendukung pengembangan yang efisien dan berkelanjutan dalam lingkungan produksi yang beragam.

## api.php

- Konfigurasi route, di mana route tertentu digunakan untuk menangani proses otentikasi pengguna seperti 'register' dan 'login' menggunakan metode POST. Selanjutnya, grup route dilindungi middleware 'auth:sanctum', memastikan hanya pengguna yang terotentikasi yang dapat mengaksesnya. Di dalam grup tersebut, terdapat route untuk halaman utama ('/home'), daftar pengguna ('/user'), dan logout ('/logout'). Route '/logout' digunakan untuk mengakhiri sesi pengguna yang terotentikasi.
``` php
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
```
- Buat file .env lalu select all dan copy isi dari .env.example ke dalam file .env
- Buat database
- Dalam file .env ganti value <strong>DB_CONNECTION</strong> jadi 'mysql' lalu uncomment <strong>DB_HOST</strong>, <strong>DB_PORT</strong>, <strong>DB_DATABASE</strong>, <strong>DB_USERNAME</strong> dan <strong>DB_PASSWORD</strong>
- Dalam file .env sesuaikan value <strong>DB_DATABASE</strong> dengan nama database yang sudah dibuat 
- Buka terminal lalu Generate value <strong>APP_KEY</strong> :
``` bash
php artisan key:generate
```
- Install Asset Bundler via Vite :
``` bash
npm install vite
```
- Run Asset Bundler :
``` bash
npm run dev
```
- ketik 'vite'
- Buka terminal baru lalu migrate database :
``` bash
php artisan migrate:fresh
```
- Run development server :
``` bash
php artisan serve
```
- <strong>mete.<strong>

## Regards

theNiba
