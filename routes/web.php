<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\AuthController;

// Роуты для получения информации
Route::get('/info/server', [InfoController::class, 'server']);
Route::get('/info/client', [InfoController::class, 'client']);
Route::get('/info/database', [InfoController::class, 'database']);

// Роуты для регистрации и авторизации
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Роуты для авторизованных пользователей (middleware auth:api)
Route::middleware('auth:api')->get('/user', [AuthController::class, 'user']);
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/tokens', [AuthController::class, 'tokens']);
Route::middleware('auth:api')->post('/revoke-all-tokens', [AuthController::class, 'revokeAllTokens']);
Route::middleware('auth:api')->post('/change-password', [AuthController::class, 'changePassword']);
Route::middleware('auth:api')->post('/refresh', [AuthController::class, 'refresh']);  // Маршрут для обновления токена
