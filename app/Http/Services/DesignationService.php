<?php

namespace App\Http\Services;

use App\Http\Contracts\DesignationServiceInterface;
use App\Models\Designation;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class DesignationService implements DesignationServiceInterface
{
    use HasAdvancedFilter;

    public function getAll(): LengthAwarePaginator|Collection
    {
        return $this->applyAdvancedFilter(Designation::query(), request());
    }

    public function getById(int $id): ?Designation
    {
        return Designation::find($id);
    }

    public function create(array $data): Designation
    {
        return Designation::create($data);
    }

    public function update(int $id, array $data): Designation
    {
        $model = Designation::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Designation::destroy($id);
    }
}
