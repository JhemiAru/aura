<?php
// app/Models/GymClass.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name', 'trainer_id', 'start_time', 'end_time', 'day_of_week',
        'capacity', 'enrolled', 'room', 'description', 'level', 'is_active', 'price'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'capacity' => 'integer',
        'enrolled' => 'integer',
        'price' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function getAvailableSpotsAttribute()
    {
        return $this->capacity - $this->enrolled;
    }

    public function getIsFullAttribute()
    {
        return $this->enrolled >= $this->capacity;
    }

    public function getScheduleAttribute()
    {
        return "{$this->day_of_week} - {$this->start_time->format('H:i')} a {$this->end_time->format('H:i')}";
    }
}
