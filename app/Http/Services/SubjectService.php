<?php

namespace App\Http\Services;

use App\Http\Contracts\SubjectServiceInterface;
use App\Models\Subject;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubjectService implements SubjectServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['academic_standard', 'subject_group', 'logo_image'];

    public function getAll(): LengthAwarePaginator|Collection
    {
        $query = Subject::with($this->resource);

        if (request()->has('academic_standard_id')) {
            $query->where('academic_standard_id', request()->input('academic_standard_id'));
        }
        if (request()->has('subject_group_id')) {
            $query->where('subject_group_id', request()->input('subject_group_id'));
        }

        return $this->applyAdvancedFilter($query, request());
    }

    public function getById(int $id): ?Subject
    {
        return Subject::find($id);
    }

    public function create(array $data): Subject
    {
        return Subject::create($data);
    }

    public function update(int $id, array $data): Subject
    {
        $model = Subject::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Subject::destroy($id);
    }
}
