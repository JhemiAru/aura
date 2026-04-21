<?php
// database/migrations/2024_01_01_000001_create_attendances_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('check_in');
            $table->dateTime('check_out')->nullable();
            $table->enum('check_in_method', ['manual', 'qr', 'biometric', 'app'])->default('manual');
            $table->enum('check_out_method', ['manual', 'qr', 'biometric', 'app'])->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('check_in');
            $table->index(['member_id', 'check_in']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};