<?php

namespace App\Http\Contracts;

use App\Models\SchoolType;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SchoolTypeServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?SchoolType;
    public function create(array $data): SchoolType;
    public function update(int $id, array $data): SchoolType;
    public function delete(int $id): bool;
}
