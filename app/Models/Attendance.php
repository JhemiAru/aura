<?php
// app/Models/Attendance.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    
    protected $table = 'attendees';
    
    protected $fillable = [
        'member_id', 'check_in', 'check_out'
    ];
    
    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime'
    ];
    
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    
    public function getDurationAttribute()
    {
        if ($this->check_out) {
            $minutes = $this->check_in->diffInMinutes($this->check_out);
            $hours = floor($minutes / 60);
            $mins = $minutes % 60;
            return $hours . 'h ' . $mins . 'min';
        }
        return 'En curso';
    }
}