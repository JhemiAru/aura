<?php
// app/Models/Equipment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;
    
    // USAR LA TABLA 'equipment' DE MI BASE DE DATOS
    protected $table = 'equipment';
    
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
    
    // Estado formateado con badge
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'Bueno' => '<span class="badge bg-success">✓ Bueno</span>',
            'Regular' => '<span class="badge bg-warning">⚠ Regular</span>',
            'Mantenimiento' => '<span class="badge bg-info">🔧 Mantenimiento</span>',
            'Dañado' => '<span class="badge bg-danger">✗ Dañado</span>'
        ];
        return $badges[$this->status] ?? '<span class="badge bg-secondary">Desconocido</span>';
    }
}