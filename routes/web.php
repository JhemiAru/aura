<?php
// routes/api.php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// =============================================
// RUTAS PARA ASISTENCIAS (LAS MÁS IMPORTANTES)
// =============================================
Route::post('/attendances/checkin', [AttendanceController::class, 'checkIn']);
Route::post('/attendances/checkout/{id}', [AttendanceController::class, 'checkOut']);
Route::get('/attendances', [AttendanceController::class, 'index']);
Route::get('/attendances/stats', [AttendanceController::class, 'stats']);

// =============================================
// RUTAS PARA MIEMBROS
// =============================================
Route::get('/members', [MemberController::class, 'index']);
Route::post('/members', [MemberController::class, 'store']);
Route::get('/members/{id}', [MemberController::class, 'show']);
Route::put('/members/{id}', [MemberController::class, 'update']);
Route::delete('/members/{id}', [MemberController::class, 'destroy']);

// =============================================
// RUTAS PARA ENTRENADORES
// =============================================
Route::get('/trainers', [TrainerController::class, 'index']);
Route::post('/trainers', [TrainerController::class, 'store']);
Route::get('/trainers/{id}', [TrainerController::class, 'show']);
Route::put('/trainers/{id}', [TrainerController::class, 'update']);
Route::delete('/trainers/{id}', [TrainerController::class, 'destroy']);

// =============================================
// RUTAS PARA CLASES
// =============================================
Route::get('/classes', [ClassController::class, 'index']);
Route::post('/classes', [ClassController::class, 'store']);
Route::get('/classes/{id}', [ClassController::class, 'show']);
Route::put('/classes/{id}', [ClassController::class, 'update']);
Route::delete('/classes/{id}', [ClassController::class, 'destroy']);

// =============================================
// RUTAS PARA PAGOS
// =============================================
Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);
Route::get('/payments/{id}', [PaymentController::class, 'show']);
Route::put('/payments/{id}', [PaymentController::class, 'update']);
Route::delete('/payments/{id}', [PaymentController::class, 'destroy']);

// =============================================
// RUTAS PARA EQUIPOS
// =============================================
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::post('/equipment', [EquipmentController::class, 'store']);
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);
Route::put('/equipment/{id}', [EquipmentController::class, 'update']);
Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);

// =============================================
// RUTAS PARA DASHBOARD
// =============================================
Route::get('/dashboard/stats', [DashboardController::class, 'getStats']);

// Ruta principal para la vista
Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);