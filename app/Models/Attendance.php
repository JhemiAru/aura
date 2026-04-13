<?php
// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'date', 'check_in_time', 'check_out_time',
        'check_in_method', 'check_out_method', 'class_id', 'notes'
    ];

    protected $casts = [
        'date' => 'date',
        'check_in_time' => 'datetime',
        'check_out_time' => 'datetime'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function class()
    {
        return $this->belongsTo(GymClass::class);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('date', Carbon::today());
    }

    public function getDurationAttribute()
    {
        if ($this->check_out_time) {
            return $this->check_in_time->diffInMinutes($this->check_out_time) . ' minutos';
        }
        return 'En curso';
    }
}