<?php

namespace App\Http\Services;

use App\Http\Contracts\ExpenseHeadServiceInterface;
use App\Models\ExpenseHead;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExpenseHeadService implements ExpenseHeadServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ExpenseHead::with(['expense_group']), request());
    }

    public function getById(int $id): ?ExpenseHead
    {
        return ExpenseHead::find($id);
    }

    public function create(array $data): ExpenseHead
    {
        return ExpenseHead::create($data);
    }

    public function update(int $id, array $data): ExpenseHead
    {
        $model = ExpenseHead::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExpenseHead::destroy($id);
    }
}
