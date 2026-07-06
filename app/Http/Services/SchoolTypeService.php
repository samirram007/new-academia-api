<?php

namespace App\Http\Services;

use App\Http\Contracts\SchoolTypeServiceInterface;
use App\Models\SchoolType;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SchoolTypeService implements SchoolTypeServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(SchoolType::query(), request());
    }

    public function getById(int $id): ?SchoolType
    {
        return SchoolType::find($id);
    }

    public function create(array $data): SchoolType
    {
        return SchoolType::create($data);
    }

    public function update(int $id, array $data): SchoolType
    {
        $model = SchoolType::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) SchoolType::destroy($id);
    }
}
