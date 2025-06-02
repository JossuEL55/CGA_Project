<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Planta;
use App\Models\Tecnico;
use App\Models\OrdenTecnica;
use App\Models\Validacion;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear roles
        $adminRole      = Role::firstOrCreate(['name' => 'admin']);
        $supervisorRole = Role::firstOrCreate(['name' => 'supervisor']);
        $tecnicoRole    = Role::firstOrCreate(['name' => 'tecnico']);

        // 2. Crear usuario Admin
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@cga.ec'],
            [
                'name'     => 'Gerencia CGA',
                'password' => Hash::make('cga2025'),
            ]
        );
        $adminUser->assignRole($adminRole);

        // 3. Crear usuario Supervisor
        $supervisorUser = User::firstOrCreate(
            ['email' => 'miguelsup@cga.ec'],
            [
                'name'     => 'Miguel Ampudia',
                'password' => Hash::make('supcga'),
            ]
        );
        $supervisorUser->assignRole($supervisorRole);

        // 4. Crear usuarios Técnicos y técnicos vinculados
        $userTecnico1 = User::firstOrCreate(
            ['email' => 'janethsu@cga.ec'],
            [
                'name' => 'Janeth Suarez',
                'password' => Hash::make('accescga'),
            ]
        );
        $userTecnico1->assignRole($tecnicoRole);

        $tecnico1 = Tecnico::firstOrCreate(
            ['cedula' => '1111446677'],
            [
                'nombre'      => 'Janeth Suarez',
                'especialidad'=> 'Mecánica',
                'user_id'     => $userTecnico1->id,
            ]
        );

        $userTecnico2 = User::firstOrCreate(
            ['email' => 'eduardo@cga.ec'],
            [
                'name' => 'Eduardo Yanez',
                'password' => Hash::make('accescga1'),
            ]
        );
        $userTecnico2->assignRole($tecnicoRole);

        $tecnico2 = Tecnico::firstOrCreate(
            ['cedula' => '2222333344'],
            [
                'nombre'      => 'Eduardo Yanez',
                'especialidad'=> 'Inspección',
                'user_id'     => $userTecnico2->id,
            ]
        );

        // 5. Crear un Cliente de ejemplo
        $cliente = Cliente::firstOrCreate(
            ['ruc' => '0124456788001'],
            [
                'nombre'   => 'SLB',
                'correo'   => 'SLB@cga.ec',
                'telefono' => '09991234567',
            ]
        );

        // 6. Crear dos Plantas para ese Cliente
        $planta1 = Planta::firstOrCreate(
            [
                'id_cliente' => $cliente->id_cliente,
                'nombre'     => 'Planta Norte',
            ],
            [
                'ubicacion' => 'Tiputini',
            ]
        );

        $planta2 = Planta::firstOrCreate(
            [
                'id_cliente' => $cliente->id_cliente,
                'nombre'     => 'Planta Sur',
            ],
            [
                'ubicacion' => 'Km 8. Vía a la Joya de los Sachas',
            ]
        );

        // 7. Crear dos Órdenes Técnicas
        $orden1 = OrdenTecnica::firstOrCreate(
            [
                'descripcion'    => 'Revisión inicial de turbina',
                'fecha_servicio' => Carbon::now()->addDays(2)->toDateString(),
                'estado'         => 'Pendiente',
                'id_planta'      => $planta1->id_planta,
                'id_tecnico'     => $tecnico1->id_tecnico,
            ]
        );

        $orden2 = OrdenTecnica::firstOrCreate(
            [
                'descripcion'    => 'Mantenimiento preventivo y correctivo de tuberías',
                'fecha_servicio' => Carbon::now()->addDays(5)->toDateString(),
                'estado'         => 'Pendiente',
                'id_planta'      => $planta2->id_planta,
                'id_tecnico'     => $tecnico2->id_tecnico,
            ]
        );

        // 8. Crear una Validación para la primera orden
        $supervisorTecnico = Tecnico::where('nombre', 'Miguel Ampudia')->first();

        if (!$supervisorTecnico) {
            $supervisorTecnico = Tecnico::create([
                'nombre'       => 'Miguel Ampudia',
                'cedula'       => '9999999999',
                'especialidad' => 'Supervisor',
                'user_id'      => $supervisorUser->id,
            ]);
        }

        Validacion::firstOrCreate([
            'id_orden'          => $orden1->id_orden,
            'id_supervisor'     => $supervisorTecnico->id_tecnico,
            'estado_validacion' => 'Validada',
            'comentarios'       => 'Todo OK',
        ]);
    }
}
