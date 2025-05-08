<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1) Crear roles si no existen
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'user']);

        // 2) Crear un usuario administrador
        $admin = User::firstOrCreate(
            ['email' => 'admin@local.test'],             // unique by email
            [
                'name'     => 'Administrador',
                'password' => bcrypt('CGA24'),        // recuerda cambiarla luego
            ]
        );
        $admin->assignRole('admin');
    }
}

