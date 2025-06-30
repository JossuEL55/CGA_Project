<?php

namespace App\Repositories;

use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\OrdenTecnica;

interface OrdenTecnicaRepositoryInterface
{
    public function paginateForUser(int $perPage, $user): LengthAwarePaginator;
    public function find(int $id): OrdenTecnica;
    public function create(array $data): OrdenTecnica;
    public function update(OrdenTecnica $orden, array $data): OrdenTecnica;
}