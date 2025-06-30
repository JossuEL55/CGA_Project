<?php

namespace App\Services;

use App\Repositories\OrdenTecnicaRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\OrdenTecnica;
use Illuminate\Support\Facades\Auth;

class OrdenTecnicaService
{
    public function __construct(
        protected OrdenTecnicaRepositoryInterface $repo
    ){}

    public function listForUser(int $perPage = 10): LengthAwarePaginator
    {
        return $this->repo->paginateForUser($perPage, Auth::user());
    }

    public function get(int $id): OrdenTecnica
    {
        return $this->repo->find($id);
    }

    public function create(array $data): OrdenTecnica
    {
        return $this->repo->create($data + [
            'estado'        => 'Pendiente',
            'supervisor_id' => null,
        ]);
    }

    public function update(OrdenTecnica $orden, array $data): OrdenTecnica
    {
        return $this->repo->update($orden, $data);
    }

    public function validarOrden(OrdenTecnica $orden, string $nuevoEstado): void
    {
        $ant = $orden->estado;
        $orden = $this->repo->update($orden, [
            'estado'        => $nuevoEstado,
            'supervisor_id' => Auth::user()->tecnico->id_tecnico,
        ]);

        $orden->validaciones()->create([
            'id_orden'        => $orden->id_orden,
            'id_tecnico'      => $orden->tecnico->id_tecnico ?? null,
            'id_supervisor'   => Auth::user()->tecnico->id_tecnico,
            'estado_anterior' => $ant,
            'estado_nuevo'    => $nuevoEstado,
            'fecha_validacion'=> now(),
        ]);
    }
}
