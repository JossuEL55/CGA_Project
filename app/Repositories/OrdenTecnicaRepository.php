<?php

namespace App\Repositories;

use App\Models\OrdenTecnica;
use Illuminate\Pagination\LengthAwarePaginator;

class OrdenTecnicaRepository implements OrdenTecnicaRepositoryInterface
{
    public function paginateForUser(int $perPage, $user): LengthAwarePaginator
    {
        $query = OrdenTecnica::with(['planta.cliente','tecnico','supervisor'])
                             ->orderByDesc('created_at');

        if ($user->rol === 'tecnico') {
            $query->where('id_tecnico', $user->tecnico->id_tecnico ?? 0);
        }

        return $query->paginate($perPage);
    }

    public function find(int $id): OrdenTecnica
    {
        return OrdenTecnica::with(['planta.cliente','tecnico','supervisor'])
                           ->findOrFail($id);
    }

    public function create(array $data): OrdenTecnica
    {
        return OrdenTecnica::create($data);
    }

    public function update(OrdenTecnica $orden, array $data): OrdenTecnica
    {
        $orden->update($data);
        return $orden;
    }
}
