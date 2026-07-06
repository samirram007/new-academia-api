<?php

namespace App\Http\Services;

use App\Http\Contracts\ExaminationStandardServiceInterface;
use App\Models\ExaminationStandard;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExaminationStandardService implements ExaminationStandardServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['academic_standard', 'examination', 'subject'];

    public function getResource(): array
    {
        return $this->resource;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ExaminationStandard::with($this->resource), request());
    }

    public function getById(int $id): ?ExaminationStandard
    {
        return ExaminationStandard::find($id);
    }

    public function create(array $data): ExaminationStandard
    {
        return ExaminationStandard::create($data);
    }

    public function update(int $id, array $data): ExaminationStandard
    {
        $model = ExaminationStandard::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExaminationStandard::destroy($id);
    }
}
