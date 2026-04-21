<?php
// database/migrations/2024_01_01_000002_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('concept', 100);
            $table->date('payment_date');
            $table->enum('status', ['pagado', 'pendiente', 'vencido', 'reembolsado'])->default('pagado');
            $table->enum('payment_method', ['efectivo', 'tarjeta', 'transferencia', 'app'])->default('efectivo');
            $table->string('receipt_number', 50)->unique()->nullable();
            $table->string('transaction_id')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('payment_date');
            $table->index('status');
            $table->index('member_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};