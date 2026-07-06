<?php

namespace App\Http\Contracts;

use App\Models\ExpenseGroup;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseGroupServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ExpenseGroup;
    public function create(array $data): ExpenseGroup;
    public function update(int $id, array $data): ExpenseGroup;
    public function delete(int $id): bool;
}
