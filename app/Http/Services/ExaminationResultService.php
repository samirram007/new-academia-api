<?php

namespace App\Http\Services;

use App\Http\Contracts\ExaminationResultServiceInterface;
use App\Models\ExaminationResult;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExaminationResultService implements ExaminationResultServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = [
        'examination_schedule',
        'examination_schedule.examination_standard',
        'examination_schedule.examination_standard.examination',
        'examination_schedule.examination_standard.examination.academic_session',
        'examination_schedule.examination_standard.academic_standard',
        'examination_schedule.subject',
        'student',
    ];

    public function getResource(): array
    {
        return $this->resource;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ExaminationResult::with($this->resource), request());
    }

    public function getById(int $id): ?ExaminationResult
    {
        return ExaminationResult::with($this->resource)->find($id);
    }

    public function create(array $data): ExaminationResult
    {
        return ExaminationResult::create($data);
    }

    public function update(int $id, array $data): ExaminationResult
    {
        $model = ExaminationResult::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExaminationResult::destroy($id);
    }
}
