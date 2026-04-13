<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastname',
        'email',
        'phone',
        'address',
        'start_date',
        'end_date',
        'status',
        'membership_id',
    ];

    // Relación con membresía
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    // Relación con pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relación con asistencias
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }
}