<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'amount',
        'payment_date',
        'payment_method',
        'status',
        'receipt_number',
    ];

    // Relación con miembro
    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}