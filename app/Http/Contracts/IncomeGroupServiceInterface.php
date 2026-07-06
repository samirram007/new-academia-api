<?php

namespace App\Http\Contracts;

use App\Models\IncomeGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface IncomeGroupServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?IncomeGroup;
    public function create(array $data): IncomeGroup;
    public function update(int $id, array $data): IncomeGroup;
    public function delete(int $id): bool;
}
