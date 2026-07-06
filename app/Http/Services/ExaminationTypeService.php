<?php

namespace App\Http\Services;

use App\Http\Contracts\ExaminationTypeServiceInterface;
use App\Models\ExaminationType;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExaminationTypeService implements ExaminationTypeServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ExaminationType::query(), request());
    }

    public function getById(int $id): ?ExaminationType
    {
        return ExaminationType::find($id);
    }

    public function create(array $data): ExaminationType
    {
        return ExaminationType::create($data);
    }

    public function update(int $id, array $data): ExaminationType
    {
        $model = ExaminationType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExaminationType::destroy($id);
    }
}
