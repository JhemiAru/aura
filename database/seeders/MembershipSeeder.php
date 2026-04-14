<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Membership;

class MembershipSeeder extends Seeder
{
    public function run(): void
    {
        Membership::create([
            'name' => 'Básica',
            'description' => 'Acceso básico al gimnasio',
            'price' => 29.99,
            'duration_days' => 30,
        ]);

        Membership::create([
            'name' => 'Premium',
            'description' => 'Acceso completo + clases grupales',
            'price' => 59.99,
            'duration_days' => 30,
        ]);

        Membership::create([
            'name' => 'VIP',
            'description' => 'Acceso total + entrenador personal',
            'price' => 99.99,
            'duration_days' => 30,
        ]);

        Membership::create([
            'name' => 'Anual Básica',
            'description' => 'Membresía anual con descuento',
            'price' => 299.99,
            'duration_days' => 365,
        ]);

        Membership::create([
            'name' => 'Anual Premium',
            'description' => 'Membresía anual premium',
            'price' => 599.99,
            'duration_days' => 365,
        ]);
    }
}