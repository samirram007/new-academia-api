<?php

namespace App\Http\Contracts;

use App\Models\ExpenseHead;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseHeadServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?ExpenseHead;
    public function create(array $data): ExpenseHead;
    public function update(int $id, array $data): ExpenseHead;
    public function delete(int $id): bool;
}
