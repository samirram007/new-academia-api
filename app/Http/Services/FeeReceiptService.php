<?php

namespace App\Http\Services;

use App\Http\Contracts\FeeReceiptServiceInterface;
use App\Models\FeeReceipt;
use App\Traits\HasAcademicSession;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class FeeReceiptService implements FeeReceiptServiceInterface
{
    use HasAcademicSession, HasAdvancedFilter;

    protected $resource = ['paidBy', 'fees'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        $academicSessionId = $this->resolveAcademicSessionId(request());

        $query = FeeReceipt::with($this->resource)
            ->whereHas('fees', function ($query) use ($academicSessionId) {
                $query->where('academic_session_id', $academicSessionId);
            })
            ->orderBy('id', 'desc');
        return $this->applyAdvancedFilter($query, request());
    }


    public function getById(int $id): ?FeeReceipt
    {
        return FeeReceipt::with($this->resource)->find($id);
    }

    public function create(array $data): FeeReceipt
    {
        return FeeReceipt::create($data);
    }

    public function update(int $id, array $data): FeeReceipt
    {
        $model = FeeReceipt::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) FeeReceipt::destroy($id);
    }
}
