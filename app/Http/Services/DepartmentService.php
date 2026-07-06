<?php

namespace App\Http\Services;

use App\Http\Contracts\DepartmentServiceInterface;
use App\Models\Department;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class DepartmentService implements DepartmentServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = [];

    public function getResource(): array
    {
        return $this->resource;
    }

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Department::query(), request());
    }

    public function getById(int $id): ?Department
    {
        return Department::find($id);
    }

    public function create(array $data): Department
    {
        return Department::create($data);
    }

    public function update(int $id, array $data): Department
    {
        $model = Department::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Department::destroy($id);
    }
}
