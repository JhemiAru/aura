<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    
    // USAR LA TABLA 'payments' DE MI BASE DE DATOS
    protected $table = 'payments';
    
    protected $fillable = [
        'member_id', 'amount', 'concept', 'payment_date', 'status',
        'payment_method', 'receipt_number', 'transaction_id', 'notes'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];
    
    // Relación con el miembro
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
    
    // Método de pago formateado
    public function getPaymentMethodFormattedAttribute()
    {
        $methods = [
            'efectivo' => '💰 Efectivo',
            'tarjeta' => '💳 Tarjeta',
            'transferencia' => '🏦 Transferencia',
            'app' => '📱 App Móvil'
        ];
        return $methods[$this->payment_method] ?? $this->payment_method;
    }
    
    // Estado formateado
    public function getStatusFormattedAttribute()
    {
        $statuses = [
            'pagado' => '✅ Pagado',
            'pendiente' => '⏳ Pendiente',
            'vencido' => '❌ Vencido',
            'reembolsado' => '🔄 Reembolsado'
        ];
        return $statuses[$this->status] ?? $this->status;
    }
}