<?php

use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerAuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\IndonesiaRegionController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// (CORS preflight handled by global CORS middleware/config)

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES (Bebas Akses - Tanpa Gembok)
|--------------------------------------------------------------------------
*/

// 1. Pintu Registrasi Seller (PENTING: Ini harus di luar middleware)
// Kita buka dua jalur jaga-jaga frontend pakai salah satunya
Route::post('/sellers', [SellerController::class, 'store']); 
Route::post('/seller/register', [SellerController::class, 'store']);

// 2. Pintu Login
Route::post('seller/login', [SellerAuthController::class, 'login']);
Route::post('admin/login', [AdminAuthController::class, 'login']);

Route::apiResource('products', ProductController::class)->only(['index', 'show']);


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus Bawa Token)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return response()->json([
            'data' => $request->user(),
            'role' => $request->user() instanceof \App\Models\Seller ? 'seller' : 'admin'
        ]);
    });

    Route::post('seller/logout', [SellerAuthController::class, 'logout']);
    Route::post('admin/logout', [AdminAuthController::class, 'logout']);

    // Resource Seller:
    // Kita pakai 'except' store agar tidak bentrok dengan route public di atas,
    // atau biarkan saja karena route di atas sudah didefinisikan lebih dulu (prioritas).
    // Tapi agar aman, kita definisikan sisa resource-nya saja.
    Route::apiResource('sellers', SellerController::class)->except(['store']);

    // Endpoint Khusus Admin untuk Verifikasi Penjual
    Route::put('/sellers/{id}/approve', [SellerController::class, 'approve']);
    Route::put('/sellers/{id}/reject', [SellerController::class, 'reject']);

    Route::apiResource('products', ProductController::class);
});

// Endpoint Alamat Indonesia
Route::prefix('region')->group(function () {
    Route::get('/provinces', [IndonesiaRegionController::class, 'getProvinces']);
    Route::get('/cities/{provinceCode}', [IndonesiaRegionController::class, 'getCities']);
    Route::get('/districts/{cityCode}', [IndonesiaRegionController::class, 'getDistrics']);
    Route::get('/villages/{districtCode}', [IndonesiaRegionController::class, 'getVillages']);
});