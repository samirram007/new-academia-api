<?php

namespace App\Http\Services;

use App\Http\Contracts\SubjectGroupServiceInterface;
use App\Models\SubjectGroup;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SubjectGroupService implements SubjectGroupServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(SubjectGroup::query(), request());
    }

    public function getById(int $id): ?SubjectGroup
    {
        return SubjectGroup::find($id);
    }

    public function create(array $data): SubjectGroup
    {
        return SubjectGroup::create($data);
    }

    public function update(int $id, array $data): SubjectGroup
    {
        $model = SubjectGroup::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) SubjectGroup::destroy($id);
    }
}
