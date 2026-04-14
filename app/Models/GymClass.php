<?php
// app/Models/GymClass.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GymClass extends Model
{
    use HasFactory;
    
    // USAR LA TABLA 'classes' DE MI BASE DE DATOS
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
    
    // Relación con entrenador
    public function trainer()
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }
    
    // Cupos disponibles
    public function getAvailableSpotsAttribute()
    {
        return $this->capacity - $this->enrolled;
    }
    
    // ¿Está llena?
    public function getIsFullAttribute()
    {
        return $this->enrolled >= $this->capacity;
    }
    
    // Horario formateado
    public function getScheduleAttribute()
    {
        $days = [
            'Monday' => 'Lunes', 'Tuesday' => 'Martes', 'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves', 'Friday' => 'Viernes', 'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        $day = $days[$this->day_of_week] ?? $this->day_of_week;
        return "{$day} - {$this->start_time->format('H:i')} a {$this->end_time->format('H:i')}";
    }
}