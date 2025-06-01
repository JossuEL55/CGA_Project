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

        // Aquí podrías continuar creando otros usuarios o seeders, por ejemplo:
        // $supervisorUser = User::firstOrCreate(
        //     ['email' => 'supervisor@core.test'],
        //     [
        //         'name'     => 'Supervisor CGA',
        //         'password' => Hash::make('sup2025'),
        //     ]
        // );
        // $supervisorUser->assignRole($supRole);
        //
        // $tecnicoUser = User::firstOrCreate(
        //     ['email' => 'tecnico@core.test'],
        //     [
        //         'name'     => 'Técnico CGA',
        //         'password' => Hash::make('tec2025'),
        //     ]
        // );
        // $tecnicoUser->assignRole($tecRole);

        // Si tienes más seeders individuales, los puedes llamar así:
        // $this->call(OtroSeeder::class);
    }
}
