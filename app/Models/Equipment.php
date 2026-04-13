<?php
// app/Models/Equipment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'quantity', 'status', 'purchase_date', 'purchase_price',
        'brand', 'model', 'serial_number', 'last_maintenance',
        'next_maintenance', 'location', 'notes'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'purchase_price' => 'decimal:2',
        'purchase_date' => 'date',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date'
    ];

    public function scopeNeedsMaintenance($query)
    {
        return $query->where('next_maintenance', '<=', now()->addDays(30));
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'Bueno' => '<span class="badge bg-success">✓ Bueno</span>',
            'Regular' => '<span class="badge bg-warning">⚠ Regular</span>',
            'Mantenimiento' => '<span class="badge bg-info">🔧 Mantenimiento</span>',
            'Dañado' => '<span class="badge bg-danger">✗ Dañado</span>',
            default => '<span class="badge bg-secondary">Desconocido</span>',
        };
    }
}