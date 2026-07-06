<?php

namespace App\Http\Services;

use App\Http\Contracts\ClassRoutineServiceInterface;
use App\Models\ClassRoutine;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ClassRoutineService implements ClassRoutineServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = [
        'academic_session',
        'academic_class',
        'subject',
        'teacher',
        'room',
    ];

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(ClassRoutine::with($this->resource), request());
    }

    public function getById(int $id): ?ClassRoutine
    {
        return ClassRoutine::with($this->resource)->find($id);
    }

    public function create(array $data): ClassRoutine
    {
        return ClassRoutine::create($data);
    }

    public function update(int $id, array $data): ClassRoutine
    {
        $model = ClassRoutine::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) ClassRoutine::destroy($id);
    }
}
