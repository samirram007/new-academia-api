<?php

namespace App\Http\Services;

use App\Http\Contracts\IncomeGroupServiceInterface;
use App\Models\IncomeGroup;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class IncomeGroupService implements IncomeGroupServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(IncomeGroup::query(), request());
    }

    public function getById(int $id): ?IncomeGroup
    {
        return IncomeGroup::find($id);
    }

    public function create(array $data): IncomeGroup
    {
        return IncomeGroup::create($data);
    }

    public function update(int $id, array $data): IncomeGroup
    {
        $model = IncomeGroup::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) IncomeGroup::destroy($id);
    }
}
