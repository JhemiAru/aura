<?php
// routes/web.php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);

// ============ API RUTAS ============
// Miembros
Route::get('/api/members', [MemberController::class, 'index']);
Route::post('/api/members', [MemberController::class, 'store']);
Route::get('/api/members/{id}', [MemberController::class, 'show']);
Route::put('/api/members/{id}', [MemberController::class, 'update']);
Route::delete('/api/members/{id}', [MemberController::class, 'destroy']);
Route::post('/api/members/{id}/renew', [MemberController::class, 'renew']);

// Entrenadores
Route::apiResource('/api/trainers', TrainerController::class);

// Clases
Route::apiResource('/api/classes', ClassController::class);

// Asistencias
Route::get('/api/attendances', [AttendanceController::class, 'index']);
Route::post('/api/attendances/register', [AttendanceController::class, 'register']);
Route::post('/api/attendances/{id}/checkout', [AttendanceController::class, 'checkout']);
Route::get('/api/attendances/stats', [AttendanceController::class, 'stats']);

// Pagos
Route::apiResource('/api/payments', PaymentController::class);

// Equipos
Route::apiResource('/api/equipment', EquipmentController::class);

// Dashboard
Route::get('/api/dashboard/stats', [DashboardController::class, 'getStats']);
Route::get('/api/reports', [DashboardController::class, 'getReports']);