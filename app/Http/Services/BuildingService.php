<?php

namespace App\Http\Services;

use App\Http\Contracts\BuildingServiceInterface;
use App\Models\Building;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class BuildingService implements BuildingServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['campus'];



    public function getAll(): LengthAwarePaginator|Collection
    {
        $query = Building::with($this->resource);
        if (request()->has('campus_id')) {
            $query->where('campus_id', request()->input('campus_id'));
        }
        return $this->applyAdvancedFilter($query, request());
    }

    public function getQuery(): \Illuminate\Database\Eloquent\Builder
    {
        return Building::with($this->resource);
    }



    public function getById(int $id): ?Building
    {
        return Building::find($id);
    }

    public function create(array $data): Building
    {
        return Building::create($data);
    }

    public function update(int $id, array $data): Building
    {
        $model = Building::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Building::destroy($id);
    }
}
