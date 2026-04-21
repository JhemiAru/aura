<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    protected $table = 'payments';
    
    // Elimina 'notes' y 'transaction_id' si no las quieres usar
    protected $fillable = [
        'member_id', 'amount', 'concept', 'payment_date', 
        'payment_method', 'status', 'receipt_number'
        // 'notes', 'transaction_id'  // Comenta estas líneas si no existen
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];
    
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}