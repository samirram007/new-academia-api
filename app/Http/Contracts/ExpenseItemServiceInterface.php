<?php

namespace App\Http\Contracts;

use App\Models\ExpenseItem;
use Illuminate\Database\Eloquent\Collection;

interface ExpenseItemServiceInterface
{
    public function getAll(): Collection;
    public function getById(int $id): ?ExpenseItem;
    public function create(array $data): ExpenseItem;
    public function update(int $id, array $data): ExpenseItem;
    public function delete(int $id): bool;
}
