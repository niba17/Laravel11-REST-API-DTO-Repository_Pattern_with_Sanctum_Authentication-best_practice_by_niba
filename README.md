## About the repository

Laravel REST API dengan pendekatan Data Transfer Object (DTO), Repository Pattern, dan Sanctum Authentication memberikan kerangka kerja yang terstruktur, terorganisir, dan aman. DTO sebagai Contratcs untuk memformat dan memvalidasi data yang ditransfer antara berbagai lapisan aplikasi, menjaga keselarasan data dan meningkatkan keamanan. Repository Pattern memisahkan logika akses data dari logika bisnis, memfasilitasi pengujian terpisah dan maintenance yang lebih mudah, sementara Sanctum Authentication menyediakan lapisan keamanan yang kokoh dengan sistem token yang memungkinkan otentikasi API yang aman. Gabungan ini menciptakan arsitektur API yang skalabel, modular, dan dapat dipercaya, mendukung pengembangan yang efisien dan berkelanjutan dalam lingkungan produksi yang beragam.

## api.php

Konfigurasi route, di mana route tertentu digunakan untuk menangani proses otentikasi pengguna seperti 'register' dan 'login' menggunakan metode POST. Selanjutnya, grup route dilindungi middleware 'auth:sanctum', memastikan hanya pengguna yang terotentikasi yang dapat mengaksesnya. Di dalam grup tersebut, terdapat route untuk halaman utama ('/home'), daftar pengguna ('/user'), dan logout ('/logout'). Route '/logout' digunakan untuk mengakhiri sesi pengguna yang terotentikasi.
``` php
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/user', [UserController::class, 'index']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
```
## AuthController.php

- Function register mengambil objek AuthRequest untuk validasi data yang diterima, lalu membuat entitas baru menggunakan DTO yang diambil dari request API, kemudian dikirim kembali sebagai response dalam bentuk tertentu, dengan mempertimbangkan kemungkinan pengecualian HTTP yang mungkin terjadi selama proses ini.
- Function login mengotentikasi pengguna berdasarkan data yang diterima dari request, dan jika berhasil, membuat token otentikasi untuk pengguna tersebut.
- Function logout menghapus token akses saat ini dari pengguna yang dikaitkan dengan request lalu memberikan response untuk menunjukkan bahwa proses logout telah berhasil.
``` php
 public function register(AuthRequest $request)
    {
        try {
            $result = $this->repository->create(RegisterDTO::apiRequest($request));

            return new $this->response(['data' => $result->original], $result->getStatusCode());
        } catch (HttpException $exception) {
            return new $this->response(['error' => $exception->getMessage()], $exception->getStatusCode());
        }
    }

    public function login(AuthRequest $request)
    {
        $user = User::where('name', $request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Username atau Password tidak sesuai!'
            ], 400);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response([
            'data' => $user,
            'token' => $token,
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['data' => true], 200);
    }
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
