<?php
// app/Models/Member.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;

    protected $table = 'members';

    protected $fillable = [
        'name', 'email', 'phone', 'plan', 'status', 'expiry_date',
        'attendance_count', 'birth_date', 'gender', 'address',
        'emergency_contact', 'emergency_phone', 'health_notes',
        'notes', 'photo', 'registration_date'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'birth_date' => 'date',
        'registration_date' => 'date',
        'attendance_count' => 'integer'
    ];

    // Relaciones
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scopes para consultas comunes
    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 'inactivo');
    }

    public function scopeExpiringSoon($query, $days = 7)
    {
        return $query->where('expiry_date', '<=', Carbon::now()->addDays($days))
                     ->where('expiry_date', '>=', Carbon::now());
    }

    public function scopeByPlan($query, $plan)
    {
        return $query->where('plan', $plan);
    }

    // Accessors
    public function getPlanPriceAttribute()
    {
        return match($this->plan) {
            'Básico' => 30,
            'Premium' => 50,
            'VIP' => 80,
            'Élite' => 120,
            default => 0,
        };
    }

    public function getIsExpiringSoonAttribute()
    {
        $daysLeft = Carbon::now()->diffInDays($this->expiry_date, false);
        return $daysLeft <= 7 && $daysLeft > 0;
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'activo' => '<span class="badge bg-success">✓ Activo</span>',
            'inactivo' => '<span class="badge bg-danger">✗ Inactivo</span>',
            'suspendido' => '<span class="badge bg-warning">⚠ Suspendido</span>',
            default => '<span class="badge bg-secondary">Desconocido</span>',
        };
    }

    // Mutators
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower(trim($value));
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucwords(strtolower(trim($value)));
    }

    // Métodos útiles
    public function incrementAttendance()
    {
        $this->increment('attendance_count');
    }

    public function renewMembership($months = 1)
    {
        $this->expiry_date = Carbon::parse($this->expiry_date)->addMonths($months);
        $this->status = 'activo';
        $this->save();
        
        return $this;
    }

    public function getAttendancePercentage()
    {
        $totalDays = Carbon::parse($this->registration_date)->diffInDays(Carbon::now());
        if ($totalDays == 0) return 0;
        return round(($this->attendance_count / $totalDays) * 100);
    }
}