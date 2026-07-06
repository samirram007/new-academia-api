<?php

namespace App\Http\Contracts;

use App\Models\Fee;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface FeeServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Fee;
    public function create(array $data): Fee;
    public function update(int $id, array $data): Fee;
    public function delete(int $id): bool;
}
