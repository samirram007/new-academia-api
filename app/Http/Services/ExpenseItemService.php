<?php

namespace App\Http\Services;

use App\Http\Contracts\ExpenseItemServiceInterface;
use App\Models\ExpenseItem;
use Illuminate\Database\Eloquent\Collection;

class ExpenseItemService implements ExpenseItemServiceInterface
{
    public function getAll(): Collection
    {
        return ExpenseItem::all();
    }

    public function getById(int $id): ?ExpenseItem
    {
        return ExpenseItem::find($id);
    }

    public function create(array $data): ExpenseItem
    {
        return ExpenseItem::create($data);
    }

    public function update(int $id, array $data): ExpenseItem
    {
        $model = ExpenseItem::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExpenseItem::destroy($id);
    }
}
