<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Crear roles si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $supRole   = Role::firstOrCreate(['name' => 'supervisor']);
        $tecRole   = Role::firstOrCreate(['name' => 'tecnico']);

        // 2. Crear al menos un usuario admin de prueba
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@cga.ec'],
            [
                'name'     => 'Gerencia CGA',
                'password' => Hash::make('cga2025'),
            ]
        );
        $adminUser->assignRole($adminRole);

        $supervisor = User::firstOrCreate(
    ['email' => 'Miguelsup@cga.ec'],
    [
        'name'     => 'Miguel Ampudia',
        'password' => Hash::make('supcga')
    ]
    );
    $supervisor->assignRole($supRole);

    $tecnico1 = User::firstOrCreate(
    ['email' => 'janethsu@cga.ec'],
    [
        'name'     => 'Janeth Suarez',
        'password' => Hash::make('accescga')
    ]
);
    $tecnico1->assignRole($tecRole);

    $tecnico2 = User::firstOrCreate(
    ['email' => 'eduardo@cga.ec'],
    [
        'name'     => 'Eduardo Yanes',
        'password' => Hash::make('accescga1')
    ]
);
    $tecnico2->assignRole($tecRole);
    }
}
