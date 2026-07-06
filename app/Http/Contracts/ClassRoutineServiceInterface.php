<?php

namespace App\Http\Contracts;

use App\Models\ClassRoutine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ClassRoutineServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ClassRoutine;
    public function create(array $data): ClassRoutine;
    public function update(int $id, array $data): ClassRoutine;
    public function delete(int $id): bool;
}
