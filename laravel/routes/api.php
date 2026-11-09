<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BranchController; // 1. WAJIB PANGGIL INI AGAR TIDAK ERROR "Class not found"
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    
    // Route Autentikasi Publik
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/register', [AuthController::class, 'register']);

    // Kelompok Route Terproteksi (Wajib Bawa Token Sanctum)
    Route::middleware('auth:sanctum')->group(function () {
        
        Route::post('/auth/logout', [AuthController::class, 'logout']);
        
        // 2. DAFTARKAN RUTE BRANCH DI SINI (Hanya bisa diakses jika sudah login)
        Route::get('/branch', [BranchController::class, 'index']); // Untuk menampilkan semua cabang
        Route::post('/branch', [BranchController::class, 'store']); // Untuk membuat cabang baru
        Route::put('/branch/{branch_slug}', [BranchController::class, 'update']);
    });

});