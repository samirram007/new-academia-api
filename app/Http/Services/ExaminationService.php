<?php

namespace App\Http\Services;

use App\Http\Contracts\ExaminationServiceInterface;
use App\Models\Examination;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExaminationService implements ExaminationServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['examination_type', 'academic_session'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Examination::with($this->resource), request());
    }

    public function getById(int $id): ?Examination
    {
        return Examination::find($id);
    }

    public function create(array $data): Examination
    {
        return Examination::create($data);
    }

    public function update(int $id, array $data): Examination
    {
        $model = Examination::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Examination::destroy($id);
    }
}
