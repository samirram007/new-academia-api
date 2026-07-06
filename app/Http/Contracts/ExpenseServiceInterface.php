<?php

namespace App\Http\Contracts;

use App\Models\Expense;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseServiceInterface
{
    public function getAll(): LengthAwarePaginator|Collection;
    public function getById(int $id): ?Expense;
    public function create(array $data): Expense;
    public function update(int $id, array $data): Expense;
    public function delete(int $id): bool;
}
