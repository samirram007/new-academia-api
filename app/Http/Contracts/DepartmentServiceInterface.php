<?php

namespace App\Http\Contracts;

use App\Models\Department;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface DepartmentServiceInterface
{
    public function getResource(): array;
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Department;
    public function create(array $data): Department;
    public function update(int $id, array $data): Department;
    public function delete(int $id): bool;
}
