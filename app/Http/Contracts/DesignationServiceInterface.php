<?php

namespace App\Http\Contracts;

use App\Models\Designation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface DesignationServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Designation;
    public function create(array $data): Designation;
    public function update(int $id, array $data): Designation;
    public function delete(int $id): bool;
}
