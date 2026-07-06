<?php

namespace App\Http\Services;

use App\Http\Contracts\AcademicStandardServiceInterface;
use App\Models\AcademicStandard;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AcademicStandardService implements AcademicStandardServiceInterface
{
    use HasAdvancedFilter;
    protected $resource = [];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(AcademicStandard::query(), request());
    }

    public function getById(int $id): ?AcademicStandard
    {
        return AcademicStandard::find($id);
    }

    public function create(array $data): AcademicStandard
    {
        return AcademicStandard::create($data);
    }

    public function update(int $id, array $data): AcademicStandard
    {
        $model = AcademicStandard::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) AcademicStandard::destroy($id);
    }
}
