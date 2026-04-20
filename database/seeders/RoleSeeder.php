<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Insertar roles
        DB::table('roles')->insert([
            ['name' => 'super_admin', 'description' => 'Super Administrador - Control total', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'description' => 'Administrador - Gestión del gimnasio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'description' => 'Usuario normal - Acceso limitado', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Crear un super administrador (role_id = 1)
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear un administrador (role_id = 2)
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Crear un usuario normal (role_id = 3)
        DB::table('users')->insert([
            'name' => 'Usuario Normal',
            'email' => 'user@gmail.com',
            'password' => Hash::make('12345678'),
            'role_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('roles')->insert([
            ['name' => 'super_admin', 'description' => 'Super Administrador - Control total', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'admin', 'description' => 'Administrador - Gestión del gimnasio', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'trainer', 'description' => 'Entrenador - Gestión de clases y ejercicios', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'user', 'description' => 'Usuario normal - Acceso limitado', 'created_at' => now(), 'updated_at' => now()],
        ]);

  
}
    }
