<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'check_in',
        'check_out',
    ];

    // Relación con miembro
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}