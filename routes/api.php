<?php

use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// seller resource
Route::apiResource('sellers', SellerController::class);

// auth for sellers (token-based)
Route::post('seller/login', [SellerAuthController::class, 'login']);
Route::post('seller/logout', [SellerAuthController::class, 'logout'])->middleware('auth:sanctum');
