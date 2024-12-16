<?php

use App\Http\Controllers\Api\PembeliController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// User route for authenticated requests
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// // Grouped API routes for better organization
// Route::prefix('api')->group(function () {
//     // Routes for Pembeli (Buyer) CRUD operations
//     Route::apiResource('pembeli', PembeliController::class);

//     // Routes for Product CRUD operations
//     Route::apiResource('product', ProductController::class);
// });

Route::apiResource('pembeli', PembeliController::class);
Route::apiResource('product', ProductController::class);
