<?php
// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use HasFactory;
    
    protected $table = 'users';
    
    protected $fillable = [
        'name', 'email', 'phone', 'plan', 'status', 'expiry_date',
        'attendance_count', 'birth_date', 'gender', 'address',
        'emergency_contact', 'emergency_phone', 'registration_date',
        'role', 'password'
    ];
    
    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = [
        'expiry_date' => 'date',
        'birth_date' => 'date',
        'registration_date' => 'date'
    ];
    
    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'member_id');
    }
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'member_id');
    }
}