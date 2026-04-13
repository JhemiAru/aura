// routes/api.php
<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Route;

// API Version 1
Route::prefix('v1')->group(function () {
    
    // ========== CRUD MIEMBROS ==========
    Route::get('members', [MemberController::class, 'index']);      // READ all
    Route::post('members', [MemberController::class, 'store']);     // CREATE
    Route::get('members/{id}', [MemberController::class, 'show']);  // READ one
    Route::put('members/{id}', [MemberController::class, 'update']);// UPDATE
    Route::delete('members/{id}', [MemberController::class, 'destroy']); // DELETE
    
    // Métodos adicionales
    Route::post('members/{id}/renew', [MemberController::class, 'renewMembership']);
    Route::get('members/export/csv', [MemberController::class, 'export']);
    Route::get('members/stats/dashboard', [MemberController::class, 'stats']);
    
    // ========== CRUD ENTRENADORES ==========
    Route::apiResource('trainers', TrainerController::class);
    
    // ========== CRUD PAGOS ==========
    Route::apiResource('payments', PaymentController::class);
    Route::get('payments/{id}/receipt', [PaymentController::class, 'generateReceipt']);
    
    // ========== ASISTENCIAS ==========
    Route::post('attendances/checkin', [AttendanceController::class, 'checkIn']);
    Route::post('attendances/checkout', [AttendanceController::class, 'checkOut']);
    Route::get('attendances/today', [AttendanceController::class, 'today']);
    Route::get('attendances/member/{memberId}', [AttendanceController::class, 'memberAttendance']);
    Route::get('attendances', [AttendanceController::class, 'index']);
});