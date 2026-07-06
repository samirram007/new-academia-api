<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeItemMonthServiceInterface;
use App\Models\FeeItemMonth;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FeeItemMonthService implements FeeItemMonthServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['fee_item', 'student_session', 'academic_session', 'month'];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = FeeItemMonth::with($this->resource);
        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?FeeItemMonth
    {
        return FeeItemMonth::with($this->resource)->find($id);
    }

    public function create(array $data): FeeItemMonth
    {
        return FeeItemMonth::create($data);
    }

    public function update(int $id, array $data): FeeItemMonth
    {
        $model = FeeItemMonth::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeItemMonth::destroy($id);
    }
}
