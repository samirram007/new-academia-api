<?php

namespace App\Http\Contracts;

use App\Models\Building;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface BuildingServiceInterface
{
    public function getQuery(): \Illuminate\Database\Eloquent\Builder;

    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Building;
    public function create(array $data): Building;
    public function update(int $id, array $data): Building;
    public function delete(int $id): bool;
}
