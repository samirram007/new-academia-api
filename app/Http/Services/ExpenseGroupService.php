<?php

namespace App\Http\Services;

use App\Http\Contracts\ExpenseGroupServiceInterface;
use App\Models\ExpenseGroup;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExpenseGroupService implements ExpenseGroupServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ExpenseGroup::query(), request());
    }

    public function getById(int $id): ?ExpenseGroup
    {
        return ExpenseGroup::find($id);
    }

    public function create(array $data): ExpenseGroup
    {
        return ExpenseGroup::create($data);
    }

    public function update(int $id, array $data): ExpenseGroup
    {
        $model = ExpenseGroup::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExpenseGroup::destroy($id);
    }
}
