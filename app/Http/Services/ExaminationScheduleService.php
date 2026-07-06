<?php

namespace App\Http\Services;

use App\Http\Contracts\ExaminationScheduleServiceInterface;
use App\Models\ExaminationSchedule;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ExaminationScheduleService implements ExaminationScheduleServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = [
        'examination_standard',
        'examination_standard.examination',
        'examination_standard.examination.academic_session',
        'examination_standard.academic_standard',
        'subject',
        'teacher',
        'room',
    ];

    public function getResource(): array
    {
        return $this->resource;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ExaminationSchedule::with($this->resource), request());
    }

    public function getById(int $id): ?ExaminationSchedule
    {
        return ExaminationSchedule::with($this->resource)->find($id);
    }

    public function create(array $data): ExaminationSchedule
    {
        return ExaminationSchedule::create($data);
    }

    public function update(int $id, array $data): ExaminationSchedule
    {
        $model = ExaminationSchedule::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ExaminationSchedule::destroy($id);
    }
}
