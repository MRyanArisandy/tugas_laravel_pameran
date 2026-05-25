<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\MobilController;
use Illuminate\Support\Facades\Route;

// Rute Autentikasi
Route::post('/login', [ApiAuthController::class, 'login']);
Route::post('/logout', [ApiAuthController::class, 'logout']);

// Fitur 3: Route::apiResource — otomatis daftarkan index, store, show, update, destroy
// Middleware api.auth sudah diatur via #[Middleware] attribute di masing-masing controller
Route::apiResource('mobils', MobilController::class);
Route::apiResource('events', EventController::class);