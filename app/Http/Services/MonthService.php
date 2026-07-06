<?php

namespace App\Http\Services;

use App\Http\Contracts\MonthServiceInterface;
use App\Models\Month;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MonthService implements MonthServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = Month::query();
        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?Month
    {
        return Month::find($id);
    }

    public function create(array $data): Month
    {
        return Month::create($data);
    }

    public function update(int $id, array $data): Month
    {
        $model = Month::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Month::destroy($id);
    }
}
