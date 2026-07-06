<?php

namespace App\Http\Services;

use App\Http\Contracts\FloorServiceInterface;
use App\Models\Floor;
use App\Traits\HasAdvancedFilter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class FloorService implements FloorServiceInterface
{
    use HasAdvancedFilter;

    protected $resource = ['building', 'building.campus'];

    public function getAll(Request $request): LengthAwarePaginator|Collection
    {
        $query = Floor::with($this->resource);
        if ($request->has('building_id')) {
            $query->where('building_id', $request->input('building_id'));
        }
        return $this->applyAdvancedFilter($query, $request);
    }

    public function getById(int $id): ?Floor
    {
        return Floor::with($this->resource)->find($id);
    }

    public function create(array $data): Floor
    {
        return Floor::create($data);
    }

    public function update(int $id, array $data): Floor
    {
        $model = Floor::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete(int $id): bool
    {
        return (bool) Floor::destroy($id);
    }
}
