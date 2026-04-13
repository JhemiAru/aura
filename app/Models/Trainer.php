<?php
// app/Models/Trainer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trainer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'specialty', 'email', 'phone', 'photo', 'bio',
        'years_experience', 'certifications', 'status', 'hourly_rate',
        'work_start_time', 'work_end_time'
    ];

    protected $casts = [
        'years_experience' => 'integer',
        'hourly_rate' => 'decimal:2',
        'work_start_time' => 'datetime',
        'work_end_time' => 'datetime'
    ];

    public function classes()
    {
        return $this->hasMany(GymClass::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'activo');
    }

    public function getFullInfoAttribute()
    {
        return "{$this->name} - {$this->specialty}";
    }
}