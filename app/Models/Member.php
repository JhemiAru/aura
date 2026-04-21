<?php
// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'users'; // O 'members' según tu BD
    
    protected $fillable = [
        'name', 'email', 'phone', 'plan', 'status', 'expiry_date',
        'attendance_count', 'birth_date', 'registration_date'
    ];
    
    protected $casts = [
        'expiry_date' => 'date',
        'registration_date' => 'date',
        'attendance_count' => 'integer'
    ];
    
    // Relación con asistencias
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'member_id');
    }
    
    // Relación con pagos
    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id');
    }
    
    // Scope para miembros activos
    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }
}