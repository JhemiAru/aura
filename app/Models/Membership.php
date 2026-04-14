<?php
// app/Models/Membership.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;
    
    protected $table = 'memberships';
    
    protected $fillable = [
        'name', 'description', 'price', 'duration_days'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'duration_days' => 'integer'
    ];
}