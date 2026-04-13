<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Auth; // <--- Agrega esta línea

Route::get('/', function () {
    return view('welcome');
});

// Ruta del dashboard (protegida con autenticación)
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

// Ruta de prueba (para forzar login temporalmente)
Route::get('/test-dashboard', function () {
    // Forzar login con super_admin para probar
    $user = \App\Models\User::find(1);
    if ($user) {
        Auth::login($user);  // <--- Cambiado a Auth::login
        return redirect('/dashboard');
    }
    return "No se encontró el usuario super_admin";
});
Route::get('/prueba', function () {
    return "Hola mundo, el servidor funciona!";
});
Route::get('/prueba-dash', [App\Http\Controllers\PruebaController::class, 'index']);