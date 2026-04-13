<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id', 'amount', 'concept', 'payment_date', 'status',
        'payment_method', 'receipt_number', 'transaction_id', 'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'pagado');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }
}